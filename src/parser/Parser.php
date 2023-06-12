<?php
interface Parser
{
  public function getFileName(): string;
  public function getDocument(): array;
  public function getFailureCode(): string;
  public function getFailureMessage(): string;
  public function getCurrency(): string;
  public function getRecords($startIndex): array;
}
?>