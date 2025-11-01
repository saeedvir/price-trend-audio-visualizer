# Price Trend Audio Visualizer

This PHP project detects trends in price data and converts them into an audio summary.  
For each detected range—**increasing**, **decreasing**, or **flat**—a corresponding MP3 clip is concatenated to generate a single audio file representing the trend over time.

---

## Features

- Detect **increasing**, **decreasing**, and **flat** price sequences from a series of prices and dates.
- Generate **audio summaries** using MP3 clips for each trend type.
- Supports **random test data generation** for experimentation.
- Works on **Windows, Linux, and macOS** with [FFmpeg](https://ffmpeg.org/) installed.

- For windows : [Download-FFMpeg](https://www.gyan.dev/ffmpeg/builds/ffmpeg-release-essentials.7z)
---

## Installation

1. Clone the repository:

```bash
git clone https://github.com/yourusername/price-trend-audio-visualizer.git
cd price-trend-audio-visualizer
