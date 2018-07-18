<?php

class SnakeDraft {

	/**
	 * List of participants
	 *
	 * @var Participant[]
	 */
	private $participants = [];


	/**
	 * Picks that will/happened
	 *
	 * @var SnakeDraftPick[]
	 */
	private $picks = array();

	/**
	 * Rounds
	 *
	 * @var SnakeDraftRound[]
	 */
	private $rounds = array();

	public function __construct( array $participants, array $picks ) {
		$this->participants = $participants;
		$this->picks        = $picks;
	}

	/**
	 *
	 * @throws SnakeDraftException
	 */
	public function initiateRandomDraft() {

		$num_participants = count( $this->participants );
		$num_picks        = count( $this->picks );
		if ( $num_participants < 1 ) {
			throw new SnakeDraftException( 'Minimum is 1 participant on the snake draft' );
		}

		if ( $num_participants > $num_picks ) {
			throw new SnakeDraftException( 'Participants must be greater than number match to pick' );
		}

		$num_rounds = ceil( $num_picks / count( $this->participants ) );

		$max_picks_per_round = $num_participants;

		$picks_stack = $this->picks;

		//create rounds
		for ( $i = 1; $i <= $num_rounds; $i ++ ) {
			$participant_on_round = $this->participants;
			// snake it up
			if ( 0 === $i % 2 ) {
				$participant_on_round = array_reverse( $participant_on_round );
			}

			$participant_picks = array();
			for ( $p = 1; $p <= $max_picks_per_round; $p ++ ) {

				// when nothing to pick break
				$pick = array_shift( $picks_stack );
				if ( empty( $pick ) ) {
					break;
				}

				$participant         = array_shift( $participant_on_round );
				$participant_picks[] = new SnakeDraftParticipantPick( $i, $participant );
			}

			$this->rounds[] = new SnakeDraftRound( $i, (string) $i, $participant_picks );
		}

	}

	public function setRounds( array $rounds ) {
		$this->rounds = $rounds;
	}

	public function isCompleted() {
		$next_incomplete_round = $this->getNextIncompleteRound();

		return is_null( $next_incomplete_round );
	}

	public function getNextParticipantPick() {
		$round = $this->getNextIncompleteRound();
		if ( ! is_null( $round ) ) {
			return $round->getNextParticipantToPick();
		}

		return null;
	}

	public function getPickedIds(): array {
		$picked_ids = [];
		foreach ( $this->rounds as $round ) {
			if ( $round->isEmptyPick() ) {
				break;
			}
			$pickeds = $round->getPickedArrray();
			foreach ( $pickeds as $picked ) {
				$picked_ids[] = $picked->getId();
			}
		}


		return $picked_ids;
	}

	public function getAvailablePicks() {
		$available_picks = array();
		$picked_ids      = $this->getPickedIds();


		foreach ( $this->picks as $pick ) {
			if ( ! in_array( $pick->getId(), $picked_ids ) ) {
				$available_picks[] = $pick;
			}
		}


		return $available_picks;
	}

	/**
	 * @return null|SnakeDraftRound
	 */
	public function getNextIncompleteRound() {
		foreach ( $this->rounds as $round ) {
			if ( ! $round->isCompleted() ) {
				return $round;
			}
		}

		return null;
	}

	public function toArray(): array {
		$array = [];
		foreach ( $this->rounds as $round ) {
			$array[] = $round->toArray();
		}

		return $array;
	}

	public function printRounds() {
		$SEPARATOR = "<br/>";
		if ( 'cli' == PHP_SAPI ) {
			$SEPARATOR = "\n";
		}

		foreach ( $this->rounds as $round ) {
			echo "[Round #" . $round->getName() . "] Pick Orders {$SEPARATOR}";
			echo "======={$SEPARATOR}";
			foreach ( $round->getParticipantPicks() as $participantPicks ) {
				$picked = '';
				if ( $participantPicks->isPicked() ) {
					$picked = "\t : " . $participantPicks->getPick()->getName() . " [" . $participantPicks->getPick()->getId() . "]";
				}
				echo $participantPicks->getParticipant()->getName() . "$picked{$SEPARATOR}";
			}
			echo "{$SEPARATOR}";
			echo "{$SEPARATOR}";
		}
	}
}
