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

    public function __construct(string $xml)
    {
        $this->loadXml($xml);
    }

    public static function load(string $filename): self
    {
        return new self((string) file_get_contents($filename));
    }

    public static function fromXml(string $xml): self
    {
        return new self($xml);
    }

    public static function fromHex($hex, $tie = null): self
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

        $operations = $record->xpath('//PilotOperationRecord[@Name]');
        if ($operations === false) {
            $operations = [];
        }

        foreach ($operations as $operation) {
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
