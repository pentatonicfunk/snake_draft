<?php

class SnakeDraftParticipantPick {

	/**
	 *
	 * @var SnakeDraftPick
	 */
	private $pick = null;

	/**
	 * @var Participant
	 */
	private $participant = null;

	private $id = 0;

	public function __construct( int $id, Participant $participant, SnakeDraftPick $pick = null ) {

		$this->participant = $participant;
		$this->pick        = $pick;
		$this->id          = $id;
	}

	public function isPicked(): bool {
		return ! is_null( $this->pick );
	}

	public function getParticipant() {
		return $this->participant;
	}

	/**
	 * @return SnakeDraftPick
	 */
	public function getPick() {
		return $this->pick;
	}

	public function setPick( SnakeDraftPick $pick ) {
		$this->pick = $pick;
	}

	public function toArray() {
		return [
			'id'          => $this->id,
			'participant' => $this->participant->toArray(),
			'pick'        => ( is_null( $this->pick ) ? null : $this->pick->toArray() ),
		];
	}
}
