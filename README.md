#Snake Draft

![Snake Draft](https://media.giphy.com/media/1yT8YNICicBjhqwvF3/giphy.gif)

```php
$picks = array(
	new SnakeDraftPick( 1, "Edmonton\tSaturday, 17 November, 2018 8:00 PM" ),
	new SnakeDraftPick( 2, "Vancouver\tSaturday, Saturday, 6 October, 2018 8:00 PM" ),
	new SnakeDraftPick( 3, "Pittsburgh\tThursday, 25 October, 2018 7:00 PM" ),
	new SnakeDraftPick( 4, "Vegas\tSunday, 10 March, 2019 7:30 PM" ),
	new SnakeDraftPick( 5, "Winnipeg\tWednesday, 21 November, 2018 8:00 PM" ),
);

$participants = array(
	new Participant( 1, 'Myrna' ),
	new Participant( 2, 'Magan' ),
);

$snakeDrafter = new SnakeDraft( $participants, $picks );
$snakeDrafter->initiateRandomDraft();

$snakeDrafter->printRounds();
while ( ! $snakeDrafter->isCompleted() ) {
    ....
}
```
