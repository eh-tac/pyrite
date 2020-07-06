<?php

namespace Pyrite\EHBL;

class Battle
{
    public $platform;
    public $type;
    public $num;
    public $title;
    public $folder;
    public $missionFiles = [];
    public $resourceFiles = [];
    public $readme;
    public $firstMission = '';

    public function __construct(
        $platform,
        $type = BattleType::UNKNOWN,
        $num = 0,
        $title = '',
        $folder = '',
        $missionFiles = [],
        $resourceFiles = []
    ) {
        $this->platform = $platform;
        $this->type = $type;
        $this->num = $num;
        $this->title = $title;
        $this->folder = $folder;
        $this->missionFiles = $missionFiles;
        $this->resourceFiles = $resourceFiles;
        foreach ($resourceFiles as $file) {
            $path = $folder . $file;
            $lc = strtolower($file);
            if (strpos($lc, 'readme') !== false && file_exists($path)) {
                $this->readme = file_get_contents($path);
            }
        }
        // /downloads/battles/TIE/TC/TIETC1/
        $this->firstMission = $this->folder . $this->missionFiles[0];
    }

    public static function fromZipUpload($fileData)
    {
        $path = $fileData['tmp_name'];
        $name = str_replace('.zip', '', $fileData['name']);

        return self::fromZip($path, $name);
    }

    public static function fromEHMUpload($fileData)
    {
        $path = $fileData['tmp_name'];
        $name = str_replace('.ehm', '', $fileData['name']);

        return self::fromEHM($path, $name);
    }

    public static function fromEHM($path, $name = null, $dir = null)
    {
        $battle = self::fromZip($path, $name, $dir);
        if ($battle) {
            $battle->decrypt();
        }
        return $battle;
    }

    public static function fromZip($path, $name = null, $dir = null)
    {
        $name = $name ? $name : basename($path);
        $rand = date("Ymd");
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
        if (!count($dirContents) > 0) {
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

    public static function fromFolder($name, $dir)
    {
        list($platform, $type, $num) = self::parseKey($name);
        $dirContents = array_filter(scandir($dir), function ($f) {
            return strlen($f) > 2;
        });
        if (!count($dirContents)) {
            return null;
        }

        $manifests = [];
        $missions  = [];
        $resources = [];

        foreach ($dirContents as $filename) {
            $lcFile = strtolower($filename);
            $ext = substr($lcFile, -4, 4);
            if ($ext === '.tie') {
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

        switch ($platform) {
            case Platform::TIE:
                return \Pyrite\TIE\Battle::fromFolder($type, $num, $dir, $manifests, $missions, $resources);
            case Platform::XvT:
            case Platform::BoP:
                return \Pyrite\XvT\Battle::fromFolder($type, $num, $dir, $manifests, $missions, $resources);
            case Platform::XWA:
                return \Pyrite\XWA\Battle::fromFolder($type, $num, $dir, $manifests, $missions, $resources);
        }
    }

    public function decrypt()
    {
        $df = $this->folder . '.decrypted';
        if (file_exists($df)){
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
        return BattleIndex::build($this->name(), $this->title, $this->missionFiles);
    }

    public function name()
    {
        return $this->platform . $this->type . $this->num;
    }

    /**
     * @param Battle $zipBattle
     * @return array
     */
    public function validate($zipB){
        $errors = [];
        $ehb = $this->getBattleIndex();
        if (!$ehb->title) {
            $errors[] = "Has an EHM without a title";
        }

        // compare files
        $mine = array_map('strtolower', array_merge($this->missionFiles, $this->resourceFiles));
        $them = array_map('strtolower', array_merge($zipB->missionFiles, $zipB->resourceFiles));
        $diff = array_merge(array_diff($mine, $them), array_diff($them, $mine));
        $diff = array_filter($diff, function($f){
            return $f !== '.decrypted' && $f !== 'battle.ehb';
        });
        if (count($diff)){
            $errors[] = "Has different files in the EHM and ZIP: " . implode(", ", $diff);
        }
        foreach ($this->missionFiles as $missionFile){
            $this->validateMission($missionFile, $errors);
        }

        return $errors;
    }

    public function validateMission($missionFile, &$errors){

    }

    public static function parseKey($key)
    {
        $platform = $type = $num = '';
        foreach (Platform::$ALL as $p) {
            if (substr($key, 0, 3) === $p) {
                $platform = $p;
                $key = substr($key, 3);
                break;
            }
        }
        foreach (BattleType::$ALL as $t) {
            if (strpos($key, $t) !== false) {
                $type = $t;
                $key = str_replace($t, '', $key);
                break;
            }
        }
        $num = (int)$key;
        if (!$platform || !$type || !$num) {
            error_log("Couldn't parse $key");
        }
        return [$platform, $type, $num];
    }
}
