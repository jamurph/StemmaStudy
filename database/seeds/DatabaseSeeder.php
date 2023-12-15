<?php

use App\Assessment;
use App\AssessmentCard;
use App\Card;
use App\Connection;
use App\Set;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        $user = new User([
            'name' => 'Murph',
            'email' => 'murph@stemmastudy.com',
            'password' => bcrypt('password')
        ]);
        $user->save();
        
        $set = new Set([
            'title' => 'Instrumental Conditioning',
            'description' => 'Notes from Human Learning Chapter 4',
            'public' => true,
            'user_id' => $user->id
        ]);
        $set->save();

        

        $thorndike = new Card([
            'title' => 'Edward Thorndike',
            'definition' => 'psychologist who introduced a theory of learning emphasizing the role of experience in the strengthening and weakening of stimulus-response connections - connectionism.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $thorndike->save();

        $puzzleBoxExperiment = new Card([
            'title' => 'Puzzle Box Experiment',
            'definition' => 'a cat was placed into a box with a door that only opened when a certain device was appropriately manipulated. At first the cat would engage in numerous, apparently random behaviors until by chance the cat triggered the mechanism - opening the door. Upon subsequent returns to the box, the cat escapes in shorter and shorter time.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $puzzleBoxExperiment->save();

        (new Connection([
            'from_card_id' => $thorndike->id,
            'to_card_id' => $puzzleBoxExperiment->id,
            'title' => 'experiment',
            'description' => 'Given in his doctoral dissertation.'
        ]))->save();


        $lawOfEffect = new Card([
            'title' => 'Law of Effect',
            'definition' => 'Responses to a situation that are followed by satisfaction are strengthened; responses that are followed by discomfort are weakened',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $lawOfEffect->save();

        (new Connection([
            'from_card_id' => $thorndike->id,
            'to_card_id' => $lawOfEffect->id,
            'title' => 'discovered',
            'description' => ''
        ]))->save();

        $scientificLaw = new Tag([
            'title' => 'Scientific Law',
            'color' => '#6ec4be',
            'set_id' => $set->id
        ]);
        $scientificLaw->save();

        $lawOfEffect->tags()->attach($scientificLaw);

        $psychologist = new Tag([
            'title' => 'Psychologist',
            'color' => '#28aa80',
            'set_id' => $set->id
        ]);
        $psychologist->save();

        $thorndike->tags()->attach($psychologist);

        $skinner = new Card([
            'title' => 'B. F. Skinner',
            'definition' => 'Most famous behavioral psychologist responsible for Operant Conditioning and the Skinner box',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $skinner->save();
        $skinner->tags()->attach($psychologist);

        $skinnerbox = new Card([
            'title' => 'Skinner Box',
            'definition' => 'For rats, a box with a metal bar that, when pressed, triggers a food tray to be accessible. For birds, a plastic disk located on one wall triggers a similar food tray when pecked.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $skinnerbox->save();

        (new Connection([
            'from_card_id' => $skinner->id,
            'to_card_id' => $skinnerbox->id,
            'title' => 'experiment',
            'description' => ''
        ]))->save();
        
        $operant = new Card([
            'title' => 'Principle of Operant Conditioning',
            'definition' => 'A response that is followed by a reinforcer is strengthened and therefore more likely to occur again. The act of applying a reinforcer is called reinforcement.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $operant->save();

        (new Connection([
            'from_card_id' => $skinner->id,
            'to_card_id' => $operant->id,
            'title' => 'coined',
            'description' => '"operant" because, unlike classical conditioning, the individual is a conscious "operator"'
        ]))->save();

        $operant->tags()->attach($scientificLaw);

        $reinforcer = new Card([
            'title' => 'Reinforcer',
            'definition' => 'a stimulus or event that increases the frequency of a response it follows.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $reinforcer->save();

        (new Connection([
            'from_card_id' => $operant->id,
            'to_card_id' => $reinforcer->id,
            'title' => 'relies on',
            'description' => ''
        ]))->save();

        $conditions = new Card([
            'title' => '3 Conditions for Operant Conditioning',
            'definition' => '1. The reinforcer must follow the response. 2. Ideally, the reinforcer should follow immediately (particularly for young children). 3. The reinforcer must be contingent on the response - presented only when the desired response has occurred.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $conditions->save();

        (new Connection([
            'from_card_id' => $operant->id,
            'to_card_id' => $conditions->id,
            'title' => 'relies on',
            'description' => ''
        ]))->save();

        $primaryRein = new Card([
            'title' => 'Primary Reinforcer',
            'definition' => 'satisfies a built-in need or desire. Examples include: food, water, warmth, physical affection, and other people\'s smiles.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $primaryRein->save();

        (new Connection([
            'from_card_id' => $reinforcer->id,
            'to_card_id' => $primaryRein->id,
            'title' => 'type',
            'description' => ''
        ]))->save();

        $secondaryRein = new Card([
            'title' => 'Secondary Reinforcer',
            'definition' => 'also known as "conditioned reinforcer" - a previously neutral stimulus that has become reinforcing to a learner through repeated association with another reinforcer. Examples include: praise, good grades, and money.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $secondaryRein->save();

        (new Connection([
            'from_card_id' => $reinforcer->id,
            'to_card_id' => $secondaryRein->id,
            'title' => 'type',
            'description' => ''
        ]))->save();

        $positiveRein = new Card([
            'title' => 'Positive Reinforcement',
            'definition' => 'the presentation of a pleasant stimulus after a desired response.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $positiveRein->save();

        (new Connection([
            'from_card_id' => $operant->id,
            'to_card_id' => $positiveRein->id,
            'title' => 'type',
            'description' => 'a type of operant conditioning'
        ]))->save();

        $materialReinforcer = new Card([
            'title' => 'Material Reinforcers',
            'definition' => 'aka "tangible reinforcer" - an actual object such as food or toys.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $materialReinforcer->save();

        (new Connection([
            'from_card_id' => $positiveRein->id,
            'to_card_id' => $materialReinforcer->id,
            'title' => 'type',
            'description' => ''
        ]))->save();

        $socialReinforcer = new Card([
            'title' => 'Social Reinforcers',
            'definition' => 'a gesture or sign such as a smile, attention, or praise that one person gives another to communicate positive regard.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $socialReinforcer->save();

        (new Connection([
            'from_card_id' => $positiveRein->id,
            'to_card_id' => $socialReinforcer->id,
            'title' => 'type',
            'description' => ''
        ]))->save();

        $activityReinforcer = new Card([
            'title' => 'Activity Reinforcers',
            'definition' => 'an opportunity to participate in another activity',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $activityReinforcer->save();

        (new Connection([
            'from_card_id' => $positiveRein->id,
            'to_card_id' => $activityReinforcer->id,
            'title' => 'type',
            'description' => ''
        ]))->save();

        $premack = new Card([
            'title' => 'Premack Principle',
            'definition' => 'When a normally high-frequency response follows a normally low-frequency response, the high-frequency response will increase the frequency of the low-frequency response. ',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $premack->save();

        (new Connection([
            'from_card_id' => $activityReinforcer->id,
            'to_card_id' => $premack->id,
            'title' => 'principle',
            'description' => ''
        ]))->save();

        $negativeRein = new Card([
            'title' => 'Negative Reinforcement',
            'definition' => 'the removal of a (usually aversive) stimulus after a desired response',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $negativeRein->save();

        (new Connection([
            'from_card_id' => $operant->id,
            'to_card_id' => $negativeRein->id,
            'title' => 'type',
            'description' => 'a type of operant conditioning'
        ]))->save();

        $escape = new Card([
            'title' => 'Escape Behaviors',
            'definition' => 'people may act to remove guilt by confessing or remove anxiety by getting the homework done early. Likewise, they may lie to avoid going to school.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $escape->save();

        (new Connection([
            'from_card_id' => $negativeRein->id,
            'to_card_id' => $escape->id,
            'title' => 'type',
            'description' => ''
        ]))->save();

        $positivePunish = new Card([
            'title' => 'Positive Punishment',
            'definition' => 'the presentation of an aversive stimulus, such as a scolding or a failing grade. Also known as Punishment I',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $positivePunish->save();

        (new Connection([
            'from_card_id' => $operant->id,
            'to_card_id' => $positivePunish->id,
            'title' => 'type',
            'description' => 'a type of operant conditioning'
        ]))->save();

        $negativePunish = new Card([
            'title' => 'Negative Punishment',
            'definition' => 'the removal of a pleasant stimulus, such as monetary fines or loss of privileges.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $negativePunish->save();

        (new Connection([
            'from_card_id' => $operant->id,
            'to_card_id' => $negativePunish->id,
            'title' => 'type',
            'description' => 'a type of operant conditioning'
        ]))->save();

        $verbalRep = new Card([
            'title' => 'Verbal Reprimand',
            'definition' => 'a scolding or admonishment as punishment. These are most effective when they are immediate, brief, and unemotional while spoken quietly and in close proximity to the person being punished. Ideally, too, a reprimand should communicate that the individual is capable of better behavior.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $verbalRep->save();

        (new Connection([
            'from_card_id' => $positivePunish->id,
            'to_card_id' => $verbalRep->id,
            'title' => 'example',
            'description' => ''
        ]))->save();

        $restitution = new Card([
            'title' => 'Restitution and Overcorrection',
            'definition' => 'requires taking action that correct the results of misdeeds by returning the environment to the same state as before the misbehavior, making things better than before the behavior (overcorrection), or repeating the action in the correct fashion.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $restitution->save();

        (new Connection([
            'from_card_id' => $positivePunish->id,
            'to_card_id' => $restitution->id,
            'title' => 'example',
            'description' => ''
        ]))->save();

        $timeout = new Card([
            'title' => 'Time-out',
            'definition' => 'placing a misbehaving individual in a dull, boring situation',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $timeout->save();

        (new Connection([
            'from_card_id' => $negativePunish->id,
            'to_card_id' => $timeout->id,
            'title' => 'example',
            'description' => ''
        ]))->save();

        $inhousesuspension = new Card([
            'title' => 'In-house suspension',
            'definition' => 'essentially extended time-out lasting multiple days rather than mere minutes. Best for chronic misbehaviors when part of the session is devoted to teach appropriate behaviors.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $inhousesuspension->save();

        (new Connection([
            'from_card_id' => $negativePunish->id,
            'to_card_id' => $inhousesuspension->id,
            'title' => 'example',
            'description' => ''
        ]))->save();

        $responsecost = new Card([
            'title' => 'Response Cost',
            'definition' => 'the withdrawal of a previously earned reinforcer such as a ticket for speeding and the loss of previously earned privileges.',
            'set_id' => $set->id,
            'next_review' => Carbon::today(),
        ]);
        $responsecost->save();

        (new Connection([
            'from_card_id' => $negativePunish->id,
            'to_card_id' => $responsecost->id,
            'title' => 'example',
            'description' => ''
        ]))->save();

        /* Review */
        (new Assessment([
            'set_id' => 1,
            'completed' => true,
            'score' => 0.75
        ]))->save();

        (new AssessmentCard([
            'assessment_id' => 1,
            'score' => 0.5,
            'card_id' => 1,
        ]))->save();

        (new AssessmentCard([
            'assessment_id' => 1,
            'score' => 1,
            'card_id' => 2,
        ]))->save();

        (new AssessmentCard([
            'assessment_id' => 1,
            'score' => 1,
            'card_id' => 3,
        ]))->save();

        (new AssessmentCard([
            'assessment_id' => 1,
            'score' => 0.5,
            'card_id' => 4,
        ]))->save();

    }
}
