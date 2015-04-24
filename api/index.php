<?php
require 'dbConnect.php';
require 'Slim/Slim.php'

\Slim\SLim::registerAutoLoader();

$app = new Slim();


//If the url matchs a certain word itll go to the function specified
$app-> get('/dailyReadings','getDailyReadings');
$app-> get('/weatherReadings','getWeatherReadings');
$app-> get('/energyReadings','getEnergyReadings');
$app-> get('/weeklyReadings','getWeeklyReadings');
$app-> get('/currentProductionReadings','getCurrentProductionReadings');
$app-> get('/queryBetweenTwoPoints/:one/:two', function($one, $two)
	{

		$query = 'SELECT kwh FROM solarThermal WHERE dateRead BETWEEN '.$one.' AND '.$two;
		$typeOfReading = '{"Quired between "'.$one.' and '.$two;


	});

//Invokes that said function I believe
$app->run();



function buildApiResponse($sql, $typeOfReading)
{
	try 
	{
		
		$db = getDb();
		$stmt = $db -> query($sql);

		$readings = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo $typeOfReading . json_encode($readings) . '}';
	
	}


	catch(PDOException $e) 
	{
		//error_log($e->getMessage(), 3, '/var/tmp/phperror.log'); //Write error log
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		
	}
}

//this function will return the daily readings as a JSON object...Needs to have query written for it
function getDailyReadings()
{

	$query = '';
	$typeOfReading = '{"dailyReadings": ';

	buildApiResponse($query, $typeOfReading);


}

function getWeatherReadings($sql, $typeOfReading)
{
	$query = '';
	$typeOfReading = '{"Weather Readings": ';

	buildApiResponse($query, $typeOfReading);

}

function getEnergyReadings()
{
	$query = '';
	$typeOfReading = '{"Energy Readings": ';

	buildApiResponse($query, $typeOfReading);


}

function getWeeklyReadings()
{

	$query = 'SELECT weather FROM solarThermal where ';
	$typeOfReading = '{"Weekly Readings": ';

buildApiResponse($query, $typeOfReading);

}

function getCurrentProductionReadings()
{
	
	$query = 'SELECT btuTotal FROM solarThermal where dateRead BETWEEN CURDATE() 00:00:00 AND CURDATE 23:59:59';
	$typeOfReading = '{"Current Production Readings": ';

	buildApiResponse($query, $typeOfReading);


}




?>