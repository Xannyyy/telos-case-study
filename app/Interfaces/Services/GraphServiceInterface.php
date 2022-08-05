<?php

namespace App\Interfaces\Services;

interface GraphServiceInterface
{
    public function generateGraph($zoom, $min = null, $max = null);
    public function generateLinearRegression();
    public function generateInterpolationGraph();
}