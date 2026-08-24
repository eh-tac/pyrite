<?php

namespace Pyrite\EHBL;

use Exception;
use Pyrite\IScoreKeeper;
use Pyrite\PyriteModel;

class Battle
{
    public string $readme;
    public string $plotline;
    public string $firstMission = '';
    public array $missions = [];
    public array $scores = [];

    public function __construct(
        public Platform $platform,
        public BattleType $type = BattleType::UNKNOWN,
        public int $num = 0,
        public string $title = '',
        public string $folder = '',
        public array $missionFiles = [],
        public array $resourceFiles = []
    ) {
        foreach ($resourceFiles as $file) {
            $path = $folder . $file;
            $lc = strtolower($file);
            if (strpos($lc, 'readme') !== false && file_exists($path)) {
                $this->readme = file_get_contents($path);
            } else if (strpos($lc, 'plotline.txt') !== false && file_exists($path)) {
                $this->plotline = file_get_contents($path);
            }
        }
        // /downloads/battles/TIE/TC/TIETC1/
        if (count($missionFiles) > 0) {
            $this->firstMission = $this->folder . $this->missionFiles[0];
        }
    }

    public static function fromZipUpload(array $fileData)
    {
        $path = $fileData['tmp_name'];
        $name = str_replace('.zip', '', $fileData['name']);

        return self::fromZip($path, $name);
    }

    public static function fromEHMUpload(array $fileData)
    {
        $path = $fileData['tmp_name'];
        $name = str_replace('.ehm', '', $fileData['name']);

        return self::fromEHM($path, $name);
    }

    public static function fromEHM(string $path, string $name = null, string $dir = null)
    {
        $battle = self::fromZip($path, $name, $dir);
        if ($battle) {
            $battle->decrypt();
        }
        return $battle;
    }

    public static function fromZip(string $path, string $name = null, string $dir = null, bool $forceExtract = false)
    {
        if (!$path) {
            return false;
        }
        $info = pathinfo($path);
        $name = $name ? $name : basename($path, '.' . $info['extension']);
        $rand = date("Ymd") . rand(1, 999);
        $dir = $dir ? $dir : "/tmp/$rand$name/";
        if (substr($dir, -1, 1) !== "/") {
            $dir .= "/";
        }
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        chmod($dir, 0777);
        $dirContents = array_filter(scandir($dir), function ($f) {
            return strlen($f) > 2;
        });
        if (!count($dirContents) > 0 || $forceExtract) {
            $zip = new \ZipArchive();
            if ($zip->open($path) === true) {
                for ($f = 0; $f < $zip->numFiles; $f++) {
                    $filename = $zip->getNameIndex($f);
                    $zip->extractTo($dir, $filename);
                }
                $zip->close();
            }
        }
        return self::fromFolder($name, $dir);
    }

    public static function fromFolder(string $name, string $dir)
    {
        list($platform, $type, $num) = self::parseKey($name);
        $dirContents = array_values(array_filter(scandir($dir), function ($f) {
            return strlen($f) > 2;
        }));
        if (!count($dirContents)) {
            return null;
        }

        if (count($dirContents) === 1 && is_dir($dir . $dirContents[0])) {
            // this is a zip where everything is inside a folder. jump into that folder before looking for more stuff.
            return self::fromFolder($name, $dir . $dirContents[0] . '/');
        } else if ($platform === Platform::TFTC && is_dir($dir . 'Missions')) {
            // TFTC zips probably have a missions folder with the mission files inside. jump into that folder before looking for more stuff.
            return self::fromFolder($name, $dir . 'Missions/');
        }

        $manifests = [];
        $missions = [];
        $resources = [];

        foreach ($dirContents as $filename) {
            $lcFile = strtolower($filename);
            $ext = substr($lcFile, -4, 4);
            if ($ext === '.tie') {
                $missions[] = $filename;
            } else if ($ext === ".xwi") {
                $missions[] = $filename;
            } else {
                if ($ext === '.lfd' || $ext === '.lst') {
                    $manifests[] = $filename;
                    $resources[] = $filename;
                } else {
                    $resources[] = $filename;
                }
            }
        }
        // if this directory does not have a readme but the parent does, copy it in...
        if (!in_array('readme.txt', $resources) && file_exists(dirname($dir) . '/readme.txt')) {
            copy(dirname($dir) . '/readme.txt', $dir . 'readme.txt');
            $resources[] = 'readme.txt';
        }

        switch ($platform) {
            case Platform::TIE:
                return new \Pyrite\TIE\Battle($type, $num, $dir,  $missions, $resources);
            case Platform::XvT:
            case Platform::BoP:
                $battle = new \Pyrite\XvT\Battle($type, $num, $dir, $missions, $resources);
                $battle->platform = $platform;
                return $battle;
            case Platform::XWA:
            case Platform::TFTC:
                return new \Pyrite\XWA\Battle($type, $num, $dir, $missions, $resources);
            case Platform::XW:
                return new \Pyrite\XW\Battle($type, $num, $dir, $missions, $resources);
            default:
                return new \Pyrite\EHBL\Battle($platform, $type, $num, '', $dir, $missions, $resources);
        }
    }

    public function decrypt()
    {
        $df = $this->folder . '.decrypted';
        if (file_exists($df)) {
            return; // already decrypted!
        }
        $ehb = $this->getBattleIndex();
        $offset = $ehb->encryptionOffset;
        $originals = $this->missionFiles;
        foreach ($originals as $filename) {
            $original = file_get_contents($this->folder . $filename);
            $enc = '';
            for ($i = 0; $i < strlen($original); $i++) {
                $value = unpack('c', $original[$i])[1];
                $decrypt = $offset ^ $value;
                $enc .= pack('c', $decrypt);
            }
            file_put_contents($this->folder . $filename, $enc);
        }
        file_put_contents($df, json_encode($ehb));
    }

    public function getBattleIndex()
    {
        if (in_array('Battle.ehb', $this->resourceFiles)) {
            return BattleIndex::fromHex(file_get_contents($this->folder . 'Battle.ehb'), $this->name());
        } else {
            return $this->createBattleIndex();
        }
    }

    public function createBattleIndex()
    {
        $ehb = BattleIndex::build($this->name(), $this->title, $this->missionFiles);
        $ehb->platform = $this->platform->id();
        return $ehb;
    }

    public function name()
    {
        return $this->platform->value . $this->type->value . $this->num;
    }

    public function validate(Battle $zipB): array
    {
        $errors = [];
        $ehb = $this->getBattleIndex();
        if (!$ehb->title) {
            $errors[] = "Has an EHM without a title";
        }

        // compare files
        $mine = array_map('strtolower', array_merge($this->missionFiles, $this->resourceFiles));
        $them = array_map('strtolower', array_merge($zipB->missionFiles, $zipB->resourceFiles));
        $diff = array_merge(array_diff($mine, $them), array_diff($them, $mine));
        $diff = array_filter($diff, function ($f) {
            return $f !== '.decrypted' && $f !== 'battle.ehb';
        });
        if (count($diff)) {
            $errors[] = "Has different files in the EHM and ZIP: " . implode(", ", $diff);
        }
        foreach ($this->missionFiles as $missionFile) {
            $this->validateMission($missionFile, $errors);
        }
        foreach ($zipB->missionFiles as $missionFile) {
            $zipB->validateMission($missionFile, $errors);
        }

        return $errors;
    }

    public function validateMission(string $missionFile, array &$errors) {}

    public static function parseKey(string $key): array
    {
        $originalKey = $key;
        /** @var ?Platform $platform */ $platform = null;
        /** @var ?BattleType $type */ $type = null;
        /** @var ?int $num */ $num = null;

        $platforms = Platform::cases();
        usort($platforms, static fn(Platform $a, Platform $b) => strlen($b->value) <=> strlen($a->value));
        foreach ($platforms as $p) {
            if (substr($key, 0, strlen($p->value)) === $p->value) {
                $platform = $p;
                $key = substr($key, strlen($p->value));
                break;
            }
        }
        $battleTypes = BattleType::cases();
        usort($battleTypes, static fn(BattleType $a, BattleType $b) => strlen($b->value) <=> strlen($a->value));
        foreach ($battleTypes as $t) {
            if (substr($key, 0, strlen($t->value)) === $t->value) {
                $type = $t;
                $key = substr($key, strlen($t->value));
                break;
            }
        }
        if (!$platform || !$type || $key === '' || !ctype_digit($key)) {
            throw new Exception("Unable to parse $originalKey as the battle name. Submissions must be in the format TIETC111");
        }

        $num = (int)$key;
        return [$platform, $type, $num];
    }

    public function loadMissions()
    {
        foreach ($this->missionFiles as $file) {
            $path = $this->folder . DIRECTORY_SEPARATOR . $file;
            $contents = file_get_contents($path);

            $tie = $this->loadMission($contents);
            if ($tie) {
                $tie->loadHex();
                $this->missions[$file] = $tie;
            } else {
                $this->missions[$file] = $path;
            }
        }
    }

    public function loadScores()
    {
        // assumes missions is populated
        foreach ($this->missions as $file => $tie) {
            $sk = $this->loadScoreKeeper($tie, $file);
            if ($sk) {
                $this->scores[$file] = $sk;
            }
        }
    }

    /**
     * @return array<IScoreKeeper>
     */
    public function getScoreKeepers()
    {
        if (empty($this->missions)) {
            $this->loadMissions();
        }
        if (empty($this->scores)) {
            $this->loadScores();
        }
        return $this->scores;
    }

    public function getDiffs(Battle $originalPyrite)
    {
        $diffs = [];
        if (empty($this->missions)) {
            $this->loadMissions();
        }
        if (empty($originalPyrite->missions)) {
            $originalPyrite->loadMissions();
        }

        foreach ($this->missions as $file => $changed) {
            $original = $originalPyrite->missions[$file];

            $diffs[$file] = [
                'original' => json_encode($original->jsonSerialize(), JSON_PRETTY_PRINT),
                'changed' => json_encode($changed->jsonSerialize(), JSON_PRETTY_PRINT)
            ];
        }
        return $diffs;
    }

    private function loadMission(string $contents)
    {
        switch ($this->platform) {
            case Platform::TIE:
                return new \Pyrite\TIE\Mission($contents);
            case Platform::XvT:
            case Platform::BoP:
                return new \Pyrite\XvT\Mission($contents);
            case Platform::XWA:
            case Platform::TFTC:
                return new \Pyrite\XWA\Mission($contents);
            case Platform::XW:
                return new \Pyrite\XW\Mission($contents);
        }
    }

    protected function loadScoreKeeper(PyriteModel $TIE, string $filename)
    {
        switch ($this->platform) {
            case Platform::TIE:
                /** @var \Pyrite\TIE\Mission $TIE */
                return new \Pyrite\TIE\ScoreKeeper($TIE);
            case Platform::XvT:
            case Platform::BoP:
                /** @var \Pyrite\XvT\Mission $TIE */
                return new \Pyrite\XvT\ScoreKeeper($TIE, $filename);
            case Platform::XWA:
            case Platform::TFTC:
                /** @var \Pyrite\XWA\Mission $TIE */
                return new \Pyrite\XWA\ScoreKeeper($TIE);
            case Platform::XW:
                /** @var \Pyrite\XW\Mission $TIE */
                return new \Pyrite\XW\ScoreKeeper($TIE);
        }
    }
}
