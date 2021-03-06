<?php
/**
 * @author      Ken Guest <ken@linux.ie>
 * @license     GPL (see http://www.gnu.org/licenses/gpl.txt)
 *
 * Quick and dirty  tests for holidays in the Ukraine and Romania - phpunit tests
 * will follow shortly.
 * Check against data in the docs directory.
 */

require_once "Date/Holidays.php";

$countries = array("Germany");
foreach($countries as $country) {
    echo  "\n$country\n";
    echo str_pad("", strlen($country),"="), "\n";
    $date = getdate();
    $year = $date['year'];
    $year = 2007;
    for ($year = 2005; $year <= 2009; $year++) {
        echo "\n";
        $d1 = "$year-01-01";
        $d2 = "$year-12-31";
        $t1 = strtotime($d1);
        $t2 = strtotime($d2);

        $driver = Date_Holidays::factory($country, $year, 'en_EN');
        if (PEAR::isError($driver)) {
            fputs(STDERR, $driver->getMessage() . "\n");
            fputs(STDERR, "\n");
            exit(1);
        }

        $hols   = ($driver->getHolidaysForDatespan($t1,$t2));

        echo  '        $this->testDates'.$year. " = array(\n";
        foreach($hols as $holiday) {
            if (PEAR::isError($holiday)) {
            } else {
                $d = $holiday->getDate();
                echo  "                '",$holiday->getInternalName(),"' => array "."('day' => ",$d->format("%e") ,
                      ",\n",str_pad("", 20, ' ')  ,"'month' => ", (int) $d->format("%m") ,",\n",str_pad("", 20, ' ')  ,"'year' => ",$d->format("%Y") ,"),\n" ;
            }
        }
        echo str_pad("", 16, ' ')  ,");\n";
    }
}
?>
