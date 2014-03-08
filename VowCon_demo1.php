<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
date_default_timezone_set('Europe/Paris');

require_once('SpamChecker.class.php');  # requires VowCon.php

class ScandinavianVowConAnalyzer extends VowConAnalyzer {
  function ScandinavianVowConAnalyzer($MaxAvgScore=2.5,$MaxWordScore=5.0,$MaxBadPercent=20.0,$BadWordLimit=3.5) {
    parent::VowConAnalyzer($MaxAvgScore,$MaxWordScore,$MaxBadPercent,$BadWordLimit);
    $this->AddVowels('æøåÆØÅ');
  }
  function GetWordStatus($word,$fmt='%.2f') {
    $score = $this->GetWordScore($word);
    $scoreStr = sprintf($fmt,$score);
    if($score > $this->MaxWordScore) 
      return 'Invalid: Above max word score ('.$scoreStr.' > '.
              sprintf($fmt,$this->MaxWordScore).')';
    elseif($score > $this->BadWordLimit) 
      return 'Invalid: Above bad word limit ('.$scoreStr.' > '.
              sprintf($fmt,$this->BadWordLimit).')';
    elseif($score > $this->MaxAvgScore) 
      return 'Maybe: Above max average score ('.$scoreStr.' > '.
              sprintf($fmt,$this->MaxAvgScore).')';
    else
      return 'Valid';
  } 
}

$SpamChecker = new SpamChecker(new ScandinavianVowConAnalyzer());

$SpamChecker->LoadText('håndballkamp, tiøring, tømmerfløting, sørland, NotWordKrgz, NotARealWordButPossiblyAccepted');
$SpamChecker->VowCon->CalcTextStats();

foreach($SpamChecker->VowCon->words as $w) {
  echo $w.': '.$SpamChecker->VowCon->GetWordScore($w).' - '.
               $SpamChecker->VowCon->GetWordStatus($w)."\n";
}

#var_dump($SpamChecker->VowCon);

?>