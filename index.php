<?php
$SEPARATOR = "<br/>";
if ( 'cli' == PHP_SAPI ) {
	$SEPARATOR = "\n";
}

require_once 'SnakeDraftException.php';
require_once 'SnakeDraftPick.php';
require_once 'SnakeDraftRound.php';
require_once 'SnakeDraft.php';
require_once 'Participant.php';
require_once 'SnakeDraftParticipantPick.php';

$picks = array(
	new SnakeDraftPick( 1, "Edmonton\tSaturday, 17 November, 2018 8:00 PM" ),
	new SnakeDraftPick( 2, "Vancouver\tSaturday, Saturday, 6 October, 2018 8:00 PM" ),
	new SnakeDraftPick( 3, "Pittsburgh\tThursday, 25 October, 2018 7:00 PM" ),
	new SnakeDraftPick( 4, "Vegas\tSunday, 10 March, 2019 7:30 PM" ),
	new SnakeDraftPick( 5, "Winnipeg\tWednesday, 21 November, 2018 8:00 PM" ),
	new SnakeDraftPick( 6, "Vegas\tMonday, 19 November, 2018 7:00 PM" ),
	new SnakeDraftPick( 7, "Vancouver\tSaturday, 29 December, 2018 8:00 PM" ),
	new SnakeDraftPick( 8, "Nashville\tSaturday, 8 December, 2018 8:00 PM" ),
	new SnakeDraftPick( 9, "San Jose\tMonday, 31 December, 2018 7:00 PM" ),
	new SnakeDraftPick( 10, "Chicago\tSaturday, 3 November, 2018 8:00 PM" ),
	new SnakeDraftPick( 11, "N.Y. Rangers\tFriday, 15 March, 2019 7:00 PM" ),
	new SnakeDraftPick( 12, "Ottawa\tThursday, 21 March, 2019 7:00 PM" ),
	new SnakeDraftPick( 13, "Detroit\tFriday, 18 January, 2019 7:00 PM" ),
	new SnakeDraftPick( 14, "Boston\tWednesday, 17 October, 2018 7:30 PM" ),
	new SnakeDraftPick( 15, "St. Louis\tSaturday, 22 December, 2018 2:00 PM" ),
	new SnakeDraftPick( 16, "Minnesota\tSaturday, 2 March, 2019 8:00 PM" ),
	new SnakeDraftPick( 17, "Anaheim\tFriday, 29 March, 2019 7:00 PM" ),
);

$participants = array(
	new Participant( 1, 'Myrna' ),
	new Participant( 2, 'Magan' ),
	new Participant( 3, 'Thalia' ),
	new Participant( 4, 'Bruna' ),
	new Participant( 5, 'Chau' ),
);

try {
	$snakeDrafter = new SnakeDraft( $participants, $picks );
	$snakeDrafter->initiateRandomDraft();

	echo "[INITIAL SNAKE DRAFT ROUND]{$SEPARATOR}";
	echo "========={$SEPARATOR}";
	$snakeDrafter->printRounds();

	sleep( 3 );

	$current_round_id = 1;
	while ( ! $snakeDrafter->isCompleted() ) {

		$round = $snakeDrafter->getNextIncompleteRound();
		if ( $current_round_id != $round->getId() ) {
			echo "{$SEPARATOR}";
		}
		$current_round_id = $round->getId();

		echo "[Round #" . $round->getName() . "] Picking Phase {$SEPARATOR}";
		$participant_pick = $snakeDrafter->getNextParticipantPick();
		echo $participant_pick->getParticipant()->getName() . " picking ...{$SEPARATOR}";
		// simulate picking
		sleep( mt_rand( 0, 1 ) );
		$available_picks = $snakeDrafter->getAvailablePicks();
		$pick            = $available_picks[ array_rand( $available_picks ) ];
		$participant_pick->setPick( $pick );
		echo $participant_pick->getParticipant()->getName() . " picked\t: " . $participant_pick->getPick()->getName() . "{$SEPARATOR}";

	}
	echo "{$SEPARATOR}";
	echo "[FINAL SNAKE DRAFT ROUND]{$SEPARATOR}";
	echo "========={$SEPARATOR}";
	$snakeDrafter->printRounds();
} catch ( Exception $e ) {
	echo $e->getMessage() . "{$SEPARATOR}";
}
