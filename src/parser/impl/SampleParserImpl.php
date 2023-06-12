<?php

include __DIR__ . "/../Parser.php";

// Class definitions
class SampleParserImpl implements Parser
{
  private $csv_arr;

  private $path;

  function __construct($csv_arr, $path)
  {
    $this->csv_arr = $csv_arr;
    $this->path = $path;
  }

  public function getFileName(): string
  {
    if (!empty($this->path)) {
      return basename($this->path);
    }
    return '';
  }
  public function getDocument(): array
  {
    return $this->csv_arr;
  }
  public function getFailureCode(): string
  {
    if (count($this->csv_arr) > 0) {
      return $this->csv_arr[0][1];
    }
    return '';
  }
  public function getFailureMessage(): string
  {
    if (count($this->csv_arr) > 0) {
      return $this->csv_arr[0][2];
    }
    return '';
  }

  public function getCurrency(): string
  {

    if (count($this->csv_arr) > 0) {
      return $this->csv_arr[0][0];
    }
    return '';
  }

  public function getRecords($startIndex): array
  {
    $rcs = [];
    for ($i = $startIndex; $i < count($this->csv_arr); $i++) {
      $r = $this->csv_arr[$i];
      if (count($r) == 16) {
        $amt = !$r[8] || $r[8] == "0" ? 0 : (float) $r[8];
        $ban = !$r[6] ? "Bank account number missing" : (int) $r[6];
        $bac = !$r[2] ? "Bank branch code missing" : $r[2];
        $e2e = !$r[10] && !$r[11] ? "End to end id missing" : $r[10] . $r[11];
        $rcd = [
          "amount" => [
            "currency" => $this->getCurrency(),
            "subunits" => (int) ($amt * 100)
          ],
          "bank_account_name" => str_replace(" ", "_", strtolower($r[7])),
          "bank_account_number" => $ban,
          "bank_branch_code" => $bac,
          "bank_code" => $r[0],
          "end_to_end_id" => $e2e,
        ];
        $rcs[] = $rcd;
      }
    }
    $rcs = array_filter($rcs);

    return $rcs;
  }
}
?>