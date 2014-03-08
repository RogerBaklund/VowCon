<?php

require_once('VowCon.php');

echo "Testing VowConStats class:\n\n";

$words = array("sportsdrink","abc","bcd","aui","aaa","aaaa",
  "asdasdasd","kjhgf","aeiou","klkla",
  "recognition", "floccinauccinihilipilification",
  "paraskevidekatriaphobia","antidisestablishmentarianism");
$v = new VowConStats();
foreach($words as $word) {
  $s = $v->Stats($word);
  echo sprintf("%-30s => %.2f %s\n",$word,round($s->score,2),
    ($s->score > 5.0 ? '!!':
    ($s->score > 3.5 ? '!':'')));
}

echo "\nTesting VowConAnalyzer class:\n\n";

$v = new VowConAnalyzer();

echo "For analyzing a collection of words. There are four properties\n".
     "which can be used to configure the operation. The default values\n".
     "are as follows:\n\n";
echo 'MaxAvgScore: '.$v->MaxAvgScore."\n".
     'MaxWordScore: '.$v->MaxWordScore."\n".
     'MaxBadPercent: '.$v->MaxBadPercent."\n".
     'BadWordLimit: '.$v->BadWordLimit."\n\n".

# load words, parameter can be array of words or a string 
# which will be split using the Split() method
$v->LoadText($words);  

echo "Status for the test word collection:\n\n";

echo '$v->GetTextStatus() => '.$v->GetTextStatus()."\n";

echo 'count($v->words) => '.count($v->words)."\n";
echo '$v->TextStats->MaxScore => '.$v->TextStats->MaxScore."\n";
echo '$v->TextStats->AvgScore => '.$v->TextStats->AvgScore."\n";
echo '$v->TextStats->BadPercent => '.$v->TextStats->BadPercent."\n";

echo "\nLooping over the collection:\n\n";
foreach($v->words as $word) {
  $s = $v->GetWordScore($word);
  echo sprintf("%-30s => %.2f %s\n",$word,round($s,2),
    $v->WordIsValid($word)? # using BadWordLimit
    'OK':($s > $v->MaxWordScore ? 'Above max word score':'Above bad word limit'));
}



?>