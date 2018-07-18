<?php

class SnakeDraftRound {

	/**
	 * Picks that will/happened
	 *
	 * @var SnakeDraftParticipantPick[]
	 */
	private $participantPicks = array();

	private $id   = 0;
	private $name = '';

	public function __construct( int $id, string $name, array $participantPicks ) {
		$this->id               = $id;
		$this->name             = $name;
		$this->participantPicks = $participantPicks;
	}

	public function getName(): string {
		return $this->name;
	}

	public function getId(): int {
		return $this->id;
	}

	/**
	 * @return array|SnakeDraftParticipantPick[]
	 */
	public function getParticipantPicks() {
		return $this->participantPicks;
	}

	public function toArray() {
		$picks_to_array = [];

		foreach ( $this->participantPicks as $pick ) {
			$picks_to_array[] = $pick->toArray();
		}

		return [
			'id'    => $this->id,
			'name'  => $this->name,
			'picks' => $picks_to_array,
		];
	}

	/**
	 * @return null|SnakeDraftParticipantPick
	 */
	public function getNextParticipantToPick() {
		foreach ( $this->participantPicks as $participant_pick ) {
			if ( ! $participant_pick->isPicked() ) {
				return $participant_pick;
			}
		}

		return null;
	}

	public function isCompleted(): bool {
		foreach ( $this->participantPicks as $participant_pick ) {
			if ( ! $participant_pick->isPicked() ) {
				return false;
			}
		}

		return true;
	}

	public function isEmptyPick(): bool {
		if ( $this->isCompleted() ) {
			return false;
		}
		foreach ( $this->participantPicks as $participant_pick ) {
			if ( $participant_pick->isPicked() ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * @return SnakeDraftPick[]
	 */
	public function getPickedArrray(): array {
		$pickeds = array();
		foreach ( $this->participantPicks as $participant_pick ) {
			if ( ! $participant_pick->isPicked() ) {
				break;
			}

			$pickeds [] = $participant_pick->getPick();

		}

		return $pickeds;
	}
}
