<?
mb_internal_encoding('UTF-8');

require_once('petrovich.php');

$petrovich = new Petrovich(Petrovich::GENDER_MALE);

echo $petrovich->firstname("Калкаман", Petrovich::CASE_PREPOSITIONAL).'<br />';
echo $petrovich->firstname("Енбек", Petrovich::CASE_PREPOSITIONAL).'<br />';
echo $petrovich->firstname("Омск", Petrovich::CASE_PREPOSITIONAL).'<br />';
echo $petrovich->firstname("Экибастуз", Petrovich::CASE_PREPOSITIONAL).'<br />';

?>