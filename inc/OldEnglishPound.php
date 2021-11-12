<?php

class OldEnglishPound {

    public string $formattedValue;
    public int $valueInPennies;

    // Parts
    public int $pounds;
    public int $shillings;
    public int $pennies;
    public int $remShillings;
    public int $remPennies;

    public function __construct(string $formattedValue, int $remShillings = null, int $remPennies = null) {
        $this->formattedValue = $formattedValue;
        $this->split_to_parts();
        $this->convert_parts_to_pennies();

        $this->remShillings = !empty($remShillings) ? (int)$remShillings : 0;
        $this->remPennies = !empty($remPennies) ? (int)$remPennies : 0;
    }

    public function to_formatted_value() {
        $formattedValue = "{$this->pounds}p {$this->shillings}s {$this->pennies}d";

        $remArr = [];

        if ($this->remShillings > 0) {
            array_push($remArr, "{$this->remShillings}s");
        }

        if ($this->remPennies > 0) {
            array_push($remArr, "{$this->remPennies}d");
        }

        if (count($remArr) > 0) {
            $formattedValue .=  ' (' . implode(' ', $remArr) . ')';
        }

        return $formattedValue;
    }

    private function split_to_parts() {
        $value = str_replace(['p', 's', 'd'], '', $this->formattedValue);
        $strings = explode(' ', $value);
        $arr = array_map(function($item) { return (int)$item; }, $strings);
        $this->pounds = (int)$arr[0]; // = 20 shillings, 240 pennies
        $this->shillings = (int)$arr[1]; // = 12 pennies
        $this->pennies = (int)$arr[2];
    }

    private function convert_parts_to_pennies() {
        $pa = self::convert_pounds_to_pennies($this->pounds);
        $pb = self::convert_shillings_to_pennies($this->shillings);
        $pc = $this->pennies;
        $this->valueInPennies = ($pa + $pb + $pc);
    }

    public function sum(OldEnglishPound $secondValue) {
        $firstValuesObj = $this;
        $secondValuesObj = $secondValue;

        $totPennies = $firstValuesObj->valueInPennies + $secondValuesObj->valueInPennies;

        // Extract pounds
        $resultPounds       = (int)self::convert_pennies_to_pounds($totPennies);
        $totPennies         -= self::convert_pounds_to_pennies($resultPounds);

        // Extract Shillings
        $resultShillings    = (int)self::convert_pennies_to_shillings($totPennies);
        $totPennies         -= self::convert_shillings_to_pennies($resultShillings);

        // Extract Pennies
        $resultPennies = $totPennies;

        $formattedResult = "{$resultPounds}p {$resultShillings}s {$resultPennies}d";
        return new OldEnglishPound($formattedResult);
    }

    public function sub(OldEnglishPound $secondValue) {
        $firstValuesObj = $this;
        $secondValuesObj = $secondValue;

        $totPennies = $firstValuesObj->valueInPennies - $secondValuesObj->valueInPennies;

        // Extract pounds
        $resultPounds       = (int)$this->convert_pennies_to_pounds($totPennies);
        $totPennies         -= $this->convert_pounds_to_pennies($resultPounds);

        // Extract Shillings
        $resultShillings    = (int)$this->convert_pennies_to_shillings($totPennies);
        $totPennies         -= $this->convert_shillings_to_pennies($resultShillings);

        // Extract Pennies
        $resultPennies = $totPennies;

        $formattedResult = "{$resultPounds}p {$resultShillings}s {$resultPennies}d";
        return new OldEnglishPound($formattedResult);
    }

    public function mul(int $secondValue) {
        $firstValuesObj = $this;
        $totPennies = $firstValuesObj->valueInPennies * $secondValue;

        // Extract pounds
        $resultPounds       = (int)self::convert_pennies_to_pounds($totPennies);
        $totPennies         -= self::convert_pounds_to_pennies($resultPounds);

        // Extract Shillings
        $resultShillings    = (int)self::convert_pennies_to_shillings($totPennies);
        $totPennies         -= self::convert_shillings_to_pennies($resultShillings);

        // Extract Pennies
        $resultPennies = $totPennies;

        $formattedResult = "{$resultPounds}p {$resultShillings}s {$resultPennies}d";
        return new OldEnglishPound($formattedResult);
    }

    public function div(int $secondValue) {
        $firstValuesObj = $this;

        $totPennies = $firstValuesObj->valueInPennies / $secondValue;
        $remPennies = $firstValuesObj->valueInPennies % $secondValue;

        // Extract pounds
        $resultPounds       = (int)self::convert_pennies_to_pounds($totPennies);
        $totPennies         -= self::convert_pounds_to_pennies($resultPounds);

        // Extract Shillings
        $resultShillings    = (int)self::convert_pennies_to_shillings($totPennies);
        $totPennies         -= self::convert_shillings_to_pennies($resultShillings);


        // Extract Pennies
        $resultPennies = (int)$totPennies;

        // 5p 17s 8d / 3 = 1p 19s 2d (2d)
        // 18p 16s 1d / 15 = 1p 5s 0d (1s 1d)

        $formattedResult = "{$resultPounds}p {$resultShillings}s {$resultPennies}d";


        $remShillings = (int)self::convert_pennies_to_shillings($remPennies);
        $remPennies   -= self::convert_shillings_to_pennies($remShillings);

        return new OldEnglishPound($formattedResult, $remShillings, $remPennies);
    }

    public static function convert_pounds_to_pennies(int $pounds) {
        return $pounds * 240;
    }

    public static function convert_shillings_to_pennies(int $shillings) {
        return $shillings * 12;
    }

    public static function convert_pennies_to_pounds(int $pennies) {
        return $pennies / 240;
    }

    public static function convert_pennies_to_shillings(int $pennies) {
        return $pennies / 12;
    }
}
