<?php

namespace Pyrite\XWVM;

class PilotFile
{
    /** @var string */
    public $Name = '';

    /** @var bool */
    private $valid = false;

    /** @var string[] */
    private $errors = [];

    /** @var array<string, array{battle: string, completed: bool, status: string, missions: array<int, array<string, mixed>>}> */
    private $battles = [];

    /** @var array<int, array<string, mixed>> */
    private $missions = [];

    private $tourRecords = [];

    public function __construct(string $xml)
    {
        $this->loadXml($xml);
    }

    public static function load(string $filename): PilotFile
    {
        return new self((string) file_get_contents($filename));
    }

    public static function fromXml(string $xml): PilotFile
    {
        return new self($xml);
    }

    public static function fromHex(string $hex, ?\Pyrite\PyriteModel $TIE = NULL): PilotFile
    {
        return self::fromXml($hex);
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return array<string, array{battle: string, completed: bool, status: string, missions: array<int, array<string, mixed>>}>
     */
    public function getBattles(): array
    {
        return $this->battles;
    }

    public function getTourRecords(): array
    {
        return array_values($this->tourRecords);
    }

    /**
     * @return array<int, array{battle: string, completed: bool, status: string, missions: array<int, array<string, mixed>>}>
     */
    public function getBattleSummary(): array
    {
        return array_values($this->battles);
    }

    /**
     * @return string[]
     */
    public function listCompleteBattles(): array
    {
        return array_values(array_map(function (array $battle): string {
            return $battle['battle'];
        }, array_filter($this->battles, function (array $battle): bool {
            return (bool) $battle['completed'];
        })));
    }

    /**
     * @return array{battle: string, completed: bool, status: string, missions: array<int, array<string, mixed>>}|null
     */
    public function getBattle(string $code): ?array
    {
        return $this->battles[$code] ?? null;
    }

    public function getCompletedMissionScoresFromBattle(string $code): array
    {
        $battle = $this->getBattle($code);
        if (!$battle) {
            return [];
        }

        return array_values(array_map(function (array $mission): int {
            return (int) $mission['score'];
        }, array_filter($battle['missions'], function (array $mission): bool {
            return (bool) $mission['completed'];
        })));
    }

    public function getCompletedMissionHashesFromBattle(string $code): array
    {
        $battle = $this->getBattle($code);
        if (!$battle) {
            return [];
        }

        return array_values(array_map(function (array $mission): string {
            return $mission['hash'];
        }, array_filter($battle['missions'], function (array $mission): bool {
            return (bool) $mission['completed'];
        })));
    }

    // get the scores for all tour missions in this pilot file.
    // in order to allow processing with offsets, we include each tour but fill in 0s if incomplete
    public function getAllTourMissionScores()
    {
        $t1 = $this->getScores($this->tourRecords['tour1']['missions'] ?? []);
        $t2 = $this->getScores($this->tourRecords['tour2']['missions'] ?? []);
        $t3 = $this->getScores($this->tourRecords['tour3']['missions'] ?? []);
        $t4 = $this->getScores($this->tourRecords['tour4']['missions'] ?? []);
        $t5 = $this->getScores($this->tourRecords['tour5']['missions'] ?? []);

        return array_merge(
            count($t1) == 12 ? $t1 : array_fill(0, 12, 0),
            count($t2) == 12 ? $t2 : array_fill(0, 12, 0),
            count($t3) == 14 ? $t3 : array_fill(0, 14, 0),
            count($t4) == 20 ? $t4 : array_fill(0, 20, 0),
            count($t5) == 20 ? $t5 : array_fill(0, 20, 0)
        );
    }

    private function getScores(array $missions): array
    {
        $scores = [];
        foreach ($missions as $mission) {
            $scores[] = (int) $mission['score'];
        }
        return $scores;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getMissionScores(): array
    {
        return $this->missions;
    }

    /**
     * @return int[]
     */
    public function getCompletedMissionScores(bool $completedOnly = false): array
    {
        $missions = $completedOnly
            ? array_filter($this->missions, function (array $mission): bool {
                return (bool) $mission['completed'];
            })
            : $this->missions;

        return array_values(array_map(function (array $mission): int {
            return (int) $mission['score'];
        }, $missions));
    }

    public function getTotalScore(): int
    {
        return array_sum($this->getCompletedMissionScores(false));
    }

    private function loadXml(string $xml): void
    {
        $previous = libxml_use_internal_errors(true);
        libxml_clear_errors();

        $record = simplexml_load_string($xml);
        if ($record === false || $record->getName() !== 'PilotRecord') {
            $this->valid = false;
            $this->errors = array_map(function (\LibXMLError $error): string {
                return trim($error->message);
            }, libxml_get_errors());
            if (!$this->errors) {
                $this->errors[] = 'Expected PilotRecord XML root element.';
            }
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
            return;
        }

        $this->valid = true;
        $this->Name = (string) $record['Name'];

        $xwing = $record->xpath('//PilotGameRecord[@Id="xwing"]');

        $campaigns = $xwing[0]->xpath('//PilotTourRecord');
        if ($campaigns === false) {
            $campaigns = [];
        }

        $this->tourRecords = [];

        foreach ($campaigns as $campaign) {
            $tour = [];
            $tourId = (string) $campaign['TourId'];

            $operations = $campaign->xpath('.//PilotOperationRecord');
            if ($operations === false) {
                $operations = [];
            }

            foreach ($operations as $operation) {
                $mission = $this->tourMissionFromOperation($operation);
                if ($mission === null) {
                    continue;
                }
                $tour[] = $mission;
            }

            usort($tour, function (array $a, array $b): int {
                return $a['tourStep'] <=> $b['tourStep'];
            });

            $this->tourRecords[$tourId] = [
                'tourId' => $tourId,
                'missions' => $tour,
            ];
        }


        $customOps = $xwing[0]->xpath('//HistoricTourRecord[@TourId="custom"]//PilotOperationRecord[@Name]');
        if ($customOps === false) {
            $customOps = [];
        }

        foreach ($customOps as $operation) {
            $mission = $this->missionFromOperation($operation);
            if ($mission === null) {
                continue;
            }

            $battle = $mission['battle'];
            if (!isset($this->battles[$battle])) {
                $this->battles[$battle] = [
                    'battle' => $battle,
                    'completed' => true,
                    'status' => 'Completed',
                    'missions' => [],
                ];
            }

            if (!$mission['completed']) {
                $this->battles[$battle]['completed'] = false;
                $this->battles[$battle]['status'] = 'Incomplete';
            }

            $this->battles[$battle]['missions'][] = $mission;
            $this->missions[] = $mission;
        }

        foreach ($this->battles as &$battle) {
            usort($battle['missions'], function (array $a, array $b): int {
                return $a['mission'] <=> $b['mission'];
            });
        }
        unset($battle);

        libxml_clear_errors();
        libxml_use_internal_errors($previous);
    }

    /**
     * @return array<string, mixed>|null
     */
    private function tourMissionFromOperation(\SimpleXMLElement $operation): ?array
    {
        if (!isset($operation['Score'])) {
            return null;
        }

        return [
            'score' => (int) $operation['Score'],
            'completed' => true,
            'tourStep' => isset($operation['TourStep']) ? (int) $operation['TourStep'] : null,
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function missionFromOperation(\SimpleXMLElement $operation): ?array
    {
        $name = (string) $operation['Name'];
        if (!preg_match('/^(XWVM.+)M(\d+)$/', $name, $matches)) {
            return null;
        }

        $complete = strtolower((string) $operation['Complete']) === 'true';

        return [
            'name' => $name,
            'battle' => $matches[1],
            'mission' => (int) $matches[2],
            'score' => (int) $operation['Score'],
            'completed' => $complete,
            'tourStep' => isset($operation['TourStep']) ? (int) $operation['TourStep'] : null,
            'hash' => isset($operation['Hash']) ? (string) $operation['Hash'] : '',
        ];
    }
}
