<?php
namespace PriceTrendAudio;

class AudioGenerator
{
    public static function joinRangeAudio(array $ranges, string $outputFile = 'output.mp3',$ffmpegPath = 'ffmpeg')
    {
        $typeToFile = [
            'increasing' => __DIR__ . '/../data/up.mp3',
            'decreasing' => __DIR__ . '/../data/down.mp3',
            'flat'       => __DIR__ . '/../data/flat.mp3',
        ];

        foreach ($typeToFile as $f) {
            if (!file_exists($f)) {
                die("File not found: $f");
            }
        }

        $audioFiles = [];
        foreach ($ranges as $range) {
            if (isset($typeToFile[$range['type']])) {
                $audioFiles[] = $typeToFile[$range['type']];
            }
        }

        if (empty($audioFiles)) {
            throw new \Exception("No audio files to join.");
        }

        $listFile = tempnam(sys_get_temp_dir(), 'mp3list_');
        $content = '';
        foreach ($audioFiles as $file) {
            $content .= "file '$file'\n";
        }
        file_put_contents($listFile, $content);

        $cmd = "$ffmpegPath -y -f concat -safe 0 -i $listFile -c copy $outputFile 2>&1";
        exec($cmd, $output, $returnVar);

        unlink($listFile);

        if ($returnVar !== 0) {
            throw new \Exception("FFmpeg failed: " . implode("\n", $output));
        }

        echo "Output MP3 created: $outputFile\n";
    }

    public static function generateRandomData(int $length = 50): array
    {
        $types = ['increasing', 'decreasing', 'flat'];
        $ranges = [];
        $startDate = new \DateTime('2025-01-01');

        for ($i = 0; $i < $length; $i++) {
            $type = $types[array_rand($types)];
            $days = rand(1, 5);
            $endDate = clone $startDate;
            $endDate->modify("+{$days} days");

            $ranges[] = [
                'start' => $startDate->format('Y-m-d'),
                'end'   => $endDate->format('Y-m-d'),
                'type'  => $type
            ];

            $startDate = clone $endDate;
            $startDate->modify('+1 day');
        }

        return $ranges;
    }
}
