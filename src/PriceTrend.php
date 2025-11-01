<?php
namespace PriceTrendAudio;

class PriceTrend
{
    public static function findDataRanges(array $prices, array $dates, int $minLength = 2): array
    {
        $ranges = [];
        $startIndex = 0;
        $direction = null; // "up", "down", or "flat"
        $length = 1;

        for ($i = 1; $i < count($prices); $i++) {
            if ($prices[$i] > $prices[$i - 1]) {
                if ($direction === "down" || $direction === "flat") {
                    if ($length >= $minLength) {
                        $ranges[] = [
                            'start' => $dates[$startIndex],
                            'end' => $dates[$i - 1],
                            'type' => $direction === "up" ? 'increasing' : ($direction === "down" ? 'decreasing' : 'flat')
                        ];
                    }
                    $startIndex = $i - 1;
                    $length = 2;
                } else {
                    $length++;
                }
                $direction = "up";
            } elseif ($prices[$i] < $prices[$i - 1]) {
                if ($direction === "up" || $direction === "flat") {
                    if ($length >= $minLength) {
                        $ranges[] = [
                            'start' => $dates[$startIndex],
                            'end' => $dates[$i - 1],
                            'type' => $direction === "up" ? 'increasing' : ($direction === "down" ? 'decreasing' : 'flat')
                        ];
                    }
                    $startIndex = $i - 1;
                    $length = 2;
                } else {
                    $length++;
                }
                $direction = "down";
            } else {
                if ($direction !== "flat") {
                    if ($direction !== null && $length >= $minLength) {
                        $ranges[] = [
                            'start' => $dates[$startIndex],
                            'end' => $dates[$i - 1],
                            'type' => $direction === "up" ? 'increasing' : ($direction === "down" ? 'decreasing' : 'flat')
                        ];
                    }
                    $startIndex = $i - 1;
                    $length = 2;
                } else {
                    $length++;
                }
                $direction = "flat";
            }
        }

        if ($direction !== null && $length >= $minLength) {
            $ranges[] = [
                'start' => $dates[$startIndex],
                'end' => $dates[count($prices) - 1],
                'type' => $direction === "up" ? 'increasing' : ($direction === "down" ? 'decreasing' : 'flat')
            ];
        }

        return $ranges;
    }
}
