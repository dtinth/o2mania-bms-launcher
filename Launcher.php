<?php

$filename = isset($_SERVER['SEARCHLIST']) ? $_SERVER['SEARCHLIST'] : dirname($argv[0]) . DIRECTORY_SEPARATOR . 'Launcher_Paths.txt';
$patterns = file($filename);
@define('stderr', fopen('php://stderr', 'w'));
function h($x) { return htmlspecialchars($x); }

class Song {
	var $path;
	var $title;
	var $level = 0;
	var $genre = '';
	var $manu  = '';
	function __construct($path) {
		$this->path = realpath($path);
		$this->title = basename($path);
	}
	function load() {
		if (!is_file($this->path)) {
			return false;
		}
		$fp = fopen($this->path, 'r');
		if (!$fp) {
			return true;
		}
		while (!feof($fp)) {
			$line = trim(fgets($fp));
			if (!preg_match('~^#(\w+)\s+~', $line, $match)) {
				continue;
			}
			$first = strtoupper($match[1]);
			$second = substr($line, strlen($match[0]));
			if ($second == '') {
				continue;
			}
			if ($first == 'TITLE') {
				$this->title = $second;
			} else if ($first == 'PLAYLEVEL') {
				$this->level = intval($second);
			} else if ($first == 'ARTIST') {
				$this->manu = $second;
			} else if ($first == 'GENRE') {
				$this->genre = $second;
			}
		}
		return true;
	}
	function output() {
		fprintf(stderr, " - %s\n", $this->title);
		echo '
	<Music file="' . h($this->path) . '" title="' . h($this->title) . '" level="0" degree="' . h($this->level) . '" manu="' . h($this->manu) . '" genre="' . h($this->genre) . '" type="2"/>';
	}
}

class MusicListWriter {
	var $songs;
	function __construct($songs) {
		$this->songs = $songs;
	}
	function output() {
		echo '<?xml version="1.0" encoding="gb2312" ?>
<Music>';
		foreach ($this->songs as $song) {
			$song->output();
		}
		echo '
</Music>
';
	}
	function write($fp) {
		ob_start();
		$this->output();
		$contents = ob_get_clean();
		fwrite($fp, $contents);
	}
}

function search($pattern, &$songs) {
	foreach (array_merge(
		glob(rtrim($pattern, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '*.bms'),
		glob(rtrim($pattern, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '*.bme')
	) as $path) {
		if (basename($path) == '___bmse_temp.bms') {
			continue;
		}
		$song = new Song($path);
		if ($song->load()) {
			$songs[] = $song;
		}
	}
}

$songs = array();

fprintf(stderr, "Searching For Songs...\n");
foreach ($patterns as $pattern) {
	$pattern = trim($pattern);
	if ($pattern != '') {
		search($pattern, $songs);
	}
}

$filename = isset($_SERVER['MUSICCACHE']) ? $_SERVER['MUSICCACHE'] : dirname($argv[0]) . DIRECTORY_SEPARATOR . 'MusicCache.xml';

if (($fp = fopen($filename, 'w'))) {
	$listWriter = new MusicListWriter($songs);
	$listWriter->write($fp);
	fclose($fp);
}
