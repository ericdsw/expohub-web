<?php

use Illuminate\Database\Seeder;
use ExpoHub\User;
use ExpoHub\Fair;
use ExpoHub\FairEvent;
use ExpoHub\SponsorRank;
use ExpoHub\EventType;
use ExpoHub\Speaker;
use ExpoHub\News;
use ExpoHub\Stand;
use ExpoHub\Sponsor;
use ExpoHub\Map;
use ExpoHub\Constants\UserType;
use Illuminate\Database\Eloquent\Model;

class StagingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin user creation
        
        $adminUser = factory(User::class)->create([
        	'user_type' => UserType::TYPE_ADMIN
        ]);

        // Sponsor Ranks Creation
        
        $diamondSponsorRank = factory(SponsorRank::class)->create(['name' => 'Diamond']);
        $goldSponsorRank 	= factory(SponsorRank::class)->create(['name' => 'Gold']);
        $siverSponsorRank 	= factory(SponsorRank::class)->create(['name' => 'Silver']);

        // EventTypes Creation
        
        $workShopEventType		= factory(EventType::class)->create(['name' => 'Workshop']);
        $seminarEventType		= factory(EventType::class)->create(['name' => 'Seminar']);
        $exhibitionEventType	= factory(EventType::class)->create(['name' => 'Exhibition']);

        // Fair owners user creation
        
        $firstFairOwner 	= factory(User::class)->create(['user_type' => UserType::TYPE_USER]);
        $secondFairOwner 	= factory(User::class)->create(['user_type' => UserType::TYPE_USER]);

        // Fairs creation
        
        $firstFair = factory(Fair::class)->create([
        	'name' 			=> 'International Housing Fair',
        	'image' 		=> 'http://lorempixel.com/900/600/city/10',
        	'description' 	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tortor augue, vehicula vitae velit non, cursus facilisis felis. Maecenas eget facilisis est, vel lobortis eros. Suspendisse tincidunt libero id orci pharetra, id finibus erat tempus. Suspendisse varius tortor massa, nec pulvinar lacus rutrum vitae. Duis pharetra ornare ligula. Pellentesque leo magna, porttitor ac elit sed, molestie sodales nulla. Nulla et pellentesque lacus. Vivamus scelerisque libero a justo pulvinar faucibus a non lacus. Praesent at sapien ex. Suspendisse consectetur augue non enim semper, eget suscipit nulla semper.

        	Cras at lacus sem. Maecenas elementum laoreet sapien, nec finibus libero vehicula sit amet. Quisque sit amet ante nibh. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nullam iaculis iaculis viverra. Nullam at placerat turpis, et suscipit velit. Fusce nec nisi purus.

        	Suspendisse felis libero, convallis nec orci tempus, blandit fermentum augue. Sed euismod quis felis non porta. Cras in enim vitae velit sagittis lobortis nec vitae enim. Ut sed orci quis quam rhoncus vestibulum. Mauris sagittis eros ut fringilla egestas. Sed varius purus sed odio aliquet, et gravida nunc ultricies. Quisque a feugiat nisl, vel vestibulum lorem. Nullam eget maximus mi, ac suscipit nunc. Donec varius est massa, ac efficitur orci interdum quis. Integer enim velit, ornare at metus eu, euismod hendrerit elit.

        	Vestibulum fermentum sed dui quis venenatis. Sed sit amet ex aliquam, interdum libero non, finibus felis. Phasellus vestibulum consequat bibendum. Nam in posuere urna, a lobortis diam. Sed ut porta lectus, at varius velit. Vestibulum et lorem ac diam tempor pellentesque quis sit amet libero. Sed aliquam, lectus ac bibendum accumsan, justo dolor convallis nibh, et semper nisl massa a velit. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur ultricies, velit ac sollicitudin cursus, nisl nibh vehicula arcu, vitae commodo enim nulla vitae nisi. Aliquam mauris augue, fringilla sed venenatis at, suscipit ut lacus. Quisque vel egestas orci. Donec sagittis tincidunt imperdiet. Aliquam ut purus ac orci viverra blandit. Praesent consectetur, arcu id rhoncus pulvinar, ex lacus eleifend elit, et rhoncus tellus lacus a felis. Maecenas sed ipsum scelerisque, vulputate nulla volutpat, laoreet ligula.',
        	'website' 		=> 'google.com',
        	'starting_date' => \Carbon\Carbon::now()->subDays(5),
        	'ending_date' 	=> \Carbon\Carbon::now()->addDays(20),
        	'address' 		=> 'Figali Convention Center',
        	'latitude' 		=> 8.939652,
        	'longitude' 	=> -79.5465679,
        	'user_id' 		=> $firstFairOwner->id
        ]);

        $secondFair = factory(Fair::class)->create([
        	'name' 			=> 'World Forum: Conservation of the Environment',
        	'image' 		=> 'http://lorempixel.com/900/600/nature/1/',
        	'description' 	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tortor augue, vehicula vitae velit non, cursus facilisis felis. Maecenas eget facilisis est, vel lobortis eros. Suspendisse tincidunt libero id orci pharetra, id finibus erat tempus. Suspendisse varius tortor massa, nec pulvinar lacus rutrum vitae. Duis pharetra ornare ligula. Pellentesque leo magna, porttitor ac elit sed, molestie sodales nulla. Nulla et pellentesque lacus. Vivamus scelerisque libero a justo pulvinar faucibus a non lacus. Praesent at sapien ex. Suspendisse consectetur augue non enim semper, eget suscipit nulla semper.

        	Cras at lacus sem. Maecenas elementum laoreet sapien, nec finibus libero vehicula sit amet. Quisque sit amet ante nibh. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nullam iaculis iaculis viverra. Nullam at placerat turpis, et suscipit velit. Fusce nec nisi purus.

        	Suspendisse felis libero, convallis nec orci tempus, blandit fermentum augue. Sed euismod quis felis non porta. Cras in enim vitae velit sagittis lobortis nec vitae enim. Ut sed orci quis quam rhoncus vestibulum. Mauris sagittis eros ut fringilla egestas. Sed varius purus sed odio aliquet, et gravida nunc ultricies. Quisque a feugiat nisl, vel vestibulum lorem. Nullam eget maximus mi, ac suscipit nunc. Donec varius est massa, ac efficitur orci interdum quis. Integer enim velit, ornare at metus eu, euismod hendrerit elit.

        	Vestibulum fermentum sed dui quis venenatis. Sed sit amet ex aliquam, interdum libero non, finibus felis. Phasellus vestibulum consequat bibendum. Nam in posuere urna, a lobortis diam. Sed ut porta lectus, at varius velit. Vestibulum et lorem ac diam tempor pellentesque quis sit amet libero. Sed aliquam, lectus ac bibendum accumsan, justo dolor convallis nibh, et semper nisl massa a velit. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur ultricies, velit ac sollicitudin cursus, nisl nibh vehicula arcu, vitae commodo enim nulla vitae nisi. Aliquam mauris augue, fringilla sed venenatis at, suscipit ut lacus. Quisque vel egestas orci. Donec sagittis tincidunt imperdiet. Aliquam ut purus ac orci viverra blandit. Praesent consectetur, arcu id rhoncus pulvinar, ex lacus eleifend elit, et rhoncus tellus lacus a felis. Maecenas sed ipsum scelerisque, vulputate nulla volutpat, laoreet ligula.',
        	'website' 		=> 'google.com',
        	'starting_date' => \Carbon\Carbon::now()->subDays(5),
        	'ending_date' 	=> \Carbon\Carbon::now()->addDays(20),
        	'address' 		=> 'Biomuseo',
        	'latitude' 		=> 8.9319113,
        	'longitude' 	=> -79.5469357,
        	'user_id' 		=> $firstFairOwner->id
        ]);

        $thirdFair = factory(Fair::class)->create([
        	'name' 			=> 'Modern Business Techniques',
        	'image' 		=> 'http://lorempixel.com/900/600/business/9/',
        	'description' 	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tortor augue, vehicula vitae velit non, cursus facilisis felis. Maecenas eget facilisis est, vel lobortis eros. Suspendisse tincidunt libero id orci pharetra, id finibus erat tempus. Suspendisse varius tortor massa, nec pulvinar lacus rutrum vitae. Duis pharetra ornare ligula. Pellentesque leo magna, porttitor ac elit sed, molestie sodales nulla. Nulla et pellentesque lacus. Vivamus scelerisque libero a justo pulvinar faucibus a non lacus. Praesent at sapien ex. Suspendisse consectetur augue non enim semper, eget suscipit nulla semper.

        	Cras at lacus sem. Maecenas elementum laoreet sapien, nec finibus libero vehicula sit amet. Quisque sit amet ante nibh. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nullam iaculis iaculis viverra. Nullam at placerat turpis, et suscipit velit. Fusce nec nisi purus.

        	Suspendisse felis libero, convallis nec orci tempus, blandit fermentum augue. Sed euismod quis felis non porta. Cras in enim vitae velit sagittis lobortis nec vitae enim. Ut sed orci quis quam rhoncus vestibulum. Mauris sagittis eros ut fringilla egestas. Sed varius purus sed odio aliquet, et gravida nunc ultricies. Quisque a feugiat nisl, vel vestibulum lorem. Nullam eget maximus mi, ac suscipit nunc. Donec varius est massa, ac efficitur orci interdum quis. Integer enim velit, ornare at metus eu, euismod hendrerit elit.

        	Vestibulum fermentum sed dui quis venenatis. Sed sit amet ex aliquam, interdum libero non, finibus felis. Phasellus vestibulum consequat bibendum. Nam in posuere urna, a lobortis diam. Sed ut porta lectus, at varius velit. Vestibulum et lorem ac diam tempor pellentesque quis sit amet libero. Sed aliquam, lectus ac bibendum accumsan, justo dolor convallis nibh, et semper nisl massa a velit. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur ultricies, velit ac sollicitudin cursus, nisl nibh vehicula arcu, vitae commodo enim nulla vitae nisi. Aliquam mauris augue, fringilla sed venenatis at, suscipit ut lacus. Quisque vel egestas orci. Donec sagittis tincidunt imperdiet. Aliquam ut purus ac orci viverra blandit. Praesent consectetur, arcu id rhoncus pulvinar, ex lacus eleifend elit, et rhoncus tellus lacus a felis. Maecenas sed ipsum scelerisque, vulputate nulla volutpat, laoreet ligula.',
        	'website' 		=> 'google.com',
        	'starting_date' => \Carbon\Carbon::now()->subDays(5),
        	'ending_date' 	=> \Carbon\Carbon::now()->addDays(20),
        	'address' 		=> 'Hard Rock Hotel (Megapolis)',
        	'latitude' 		=> 8.9771906,
        	'longitude' 	=> -79.5199734,
        	'user_id' 		=> $secondFairOwner->id
        ]);

        // Sponsors Creation
        
        $firstSponsor = factory(Sponsor::class)->create([
        	'name' 				=> 'Community Housing Network',
        	'logo' 				=> 'https://realimagination.files.wordpress.com/2011/09/md-community_housing_logo.jpg',
        	'slogan' 			=> 'Lorem ipsum dolor sit amet.',
        	'website' 			=> 'google.com',
        	'fair_id' 			=> $firstFair->id,
        	'sponsor_rank_id' 	=> $goldSponsorRank->id
        ]);

        $secondSponsor = factory(Sponsor::class)->create([
        	'name' 				=> 'Eden Housing',
        	'logo' 				=> 'http://calhsng.org/wp-content/uploads/2016/01/Green-Eden-Housing-Logo-300x300.jpg',
        	'slogan' 			=> 'Lorem ipsum dolor sit amet.',
        	'website' 			=> 'google.com',
        	'fair_id' 			=> $firstFair->id,
        	'sponsor_rank_id' 	=> $goldSponsorRank->id
        ]);

        $thirdSponsor = factory(Sponsor::class)->create([
        	'name' 				=> 'Eco',
        	'logo' 				=> 'https://s-media-cache-ak0.pinimg.com/originals/39/a3/31/39a3319569558a87b9fd6709dfc8725c.jpg',
        	'slogan' 			=> 'Lorem ipsum dolor sit amet.',
        	'website' 			=> 'google.com',
        	'fair_id' 			=> $secondFair->id,
        	'sponsor_rank_id' 	=> $goldSponsorRank->id
        ]);

        $fourthSponsor = factory(Sponsor::class)->create([
        	'name' 				=> 'Colors',
        	'logo' 				=> 'https://assets.entrepreneur.com/slideshow/colors-logo.jpg',
        	'slogan' 			=> 'Lorem ipsum dolor sit amet.',
        	'website' 			=> 'google.com',
        	'fair_id' 			=> $thirdFair->id,
        	'sponsor_rank_id' 	=> $diamondSponsorRank->id
        ]);

        // Maps creation
        
        $firstMap = factory(Map::class)->create([
        	'name' 		=> 'Main',
        	'image' 	=> 'http://www.hrhpanamamegapolis.com/files/1918/mapNivelE10.png',
        	'fair_id' 	=> $secondFair->id
        ]);

        $secondMap = factory(Map::class)->create([
        	'name' 		=> 'Main',
        	'image' 	=> 'http://www.biomuseopanama.org/sites/default/files/styles/embedded-600px/public/articulos/mapa-biomuseo.jpg?itok=9voVSGH_',
        	'fair_id' 	=> $thirdFair->id,
        ]);

        // FairEvents creation
        
        $firstFairEvent = factory(FairEvent::class)->create([
        	'title' 		=> 'How To Invest In Your House',
        	'image' 		=> 'http://lorempixel.com/900/600/abstract/4/',
        	'description' 	=> 'Donec blandit sit amet erat a ornare. Vestibulum a massa at odio fringilla faucibus et vitae eros. Quisque cursus vitae lorem ac scelerisque. Donec ut justo orci. Phasellus fringilla tempus sapien quis mattis. Mauris a arcu gravida, sodales urna vitae, vestibulum ante. Cras elementum pretium egestas. Nullam scelerisque dignissim iaculis. Duis nec nibh venenatis, laoreet lorem nec, pellentesque nibh. Phasellus ultricies dui id velit pellentesque laoreet. Maecenas et lectus imperdiet diam pellentesque maximus. Ut nunc sem, maximus cursus dapibus a, pulvinar facilisis purus. Sed interdum, eros sit amet dapibus pharetra, nibh diam efficitur lacus, et fringilla mi lectus a felis. Donec sit amet aliquet lacus. Pellentesque diam velit, semper at ante sed, placerat lacinia lacus. Maecenas quis justo interdum, bibendum nulla ac, euismod justo.',
        	'date' 			=>  \Carbon\Carbon::now()->addDays(5),
        	'location' 		=> 'Second Floor',
        	'fair_id' 		=> $firstFair->id,
        	'event_type_id' => $seminarEventType->id
        ]);

        $secondFairEvent = factory(FairEvent::class)->create([
        	'title' 		=> 'Gardening 101',
        	'image' 		=> 'http://lorempixel.com/900/600/nature/8/',
        	'description' 	=> 'Donec blandit sit amet erat a ornare. Vestibulum a massa at odio fringilla faucibus et vitae eros. Quisque cursus vitae lorem ac scelerisque. Donec ut justo orci. Phasellus fringilla tempus sapien quis mattis. Mauris a arcu gravida, sodales urna vitae, vestibulum ante. Cras elementum pretium egestas. Nullam scelerisque dignissim iaculis. Duis nec nibh venenatis, laoreet lorem nec, pellentesque nibh. Phasellus ultricies dui id velit pellentesque laoreet. Maecenas et lectus imperdiet diam pellentesque maximus. Ut nunc sem, maximus cursus dapibus a, pulvinar facilisis purus. Sed interdum, eros sit amet dapibus pharetra, nibh diam efficitur lacus, et fringilla mi lectus a felis. Donec sit amet aliquet lacus. Pellentesque diam velit, semper at ante sed, placerat lacinia lacus. Maecenas quis justo interdum, bibendum nulla ac, euismod justo.',
        	'date' 			=>  \Carbon\Carbon::now()->addDays(5),
        	'location' 		=> 'Rear Terrace',
        	'fair_id' 		=> $firstFair->id,
        	'event_type_id' => $seminarEventType->id
        ]);

        $thirdFairEvent = factory(FairEvent::class)->create([
        	'title' 		=> 'Reducing Environmental Impact Caused By Our Pets',
        	'image' 		=> 'http://lorempixel.com/900/600/animals/9/',
        	'description' 	=> 'Donec blandit sit amet erat a ornare. Vestibulum a massa at odio fringilla faucibus et vitae eros. Quisque cursus vitae lorem ac scelerisque. Donec ut justo orci. Phasellus fringilla tempus sapien quis mattis. Mauris a arcu gravida, sodales urna vitae, vestibulum ante. Cras elementum pretium egestas. Nullam scelerisque dignissim iaculis. Duis nec nibh venenatis, laoreet lorem nec, pellentesque nibh. Phasellus ultricies dui id velit pellentesque laoreet. Maecenas et lectus imperdiet diam pellentesque maximus. Ut nunc sem, maximus cursus dapibus a, pulvinar facilisis purus. Sed interdum, eros sit amet dapibus pharetra, nibh diam efficitur lacus, et fringilla mi lectus a felis. Donec sit amet aliquet lacus. Pellentesque diam velit, semper at ante sed, placerat lacinia lacus. Maecenas quis justo interdum, bibendum nulla ac, euismod justo.',
        	'date' 			=>  \Carbon\Carbon::now()->addDays(5),
        	'location' 		=> 'Temporal Exhibitions Area',
        	'fair_id' 		=> $secondFair->id,
        	'event_type_id' => $seminarEventType->id
        ]);

        $fourthFairEvent = factory(FairEvent::class)->create([
        	'title' 		=> 'The Future of Water for Humanity',
        	'image' 		=> 'http://lorempixel.com/900/600/nature/10/',
        	'description' 	=> 'Donec blandit sit amet erat a ornare. Vestibulum a massa at odio fringilla faucibus et vitae eros. Quisque cursus vitae lorem ac scelerisque. Donec ut justo orci. Phasellus fringilla tempus sapien quis mattis. Mauris a arcu gravida, sodales urna vitae, vestibulum ante. Cras elementum pretium egestas. Nullam scelerisque dignissim iaculis. Duis nec nibh venenatis, laoreet lorem nec, pellentesque nibh. Phasellus ultricies dui id velit pellentesque laoreet. Maecenas et lectus imperdiet diam pellentesque maximus. Ut nunc sem, maximus cursus dapibus a, pulvinar facilisis purus. Sed interdum, eros sit amet dapibus pharetra, nibh diam efficitur lacus, et fringilla mi lectus a felis. Donec sit amet aliquet lacus. Pellentesque diam velit, semper at ante sed, placerat lacinia lacus. Maecenas quis justo interdum, bibendum nulla ac, euismod justo.',
        	'date' 			=>  \Carbon\Carbon::now()->addDays(5),
        	'location' 		=> 'Atrium',
        	'fair_id' 		=> $secondFair->id,
        	'event_type_id' => $seminarEventType->id
        ]);

        $fifthFairEvent = factory(FairEvent::class)->create([
        	'title' 		=> 'Endangered Exotic Plant Specimens Exhibition',
        	'image' 		=> 'http://lorempixel.com/900/600/nature/10/',
        	'description' 	=> 'Donec blandit sit amet erat a ornare. Vestibulum a massa at odio fringilla faucibus et vitae eros. Quisque cursus vitae lorem ac scelerisque. Donec ut justo orci. Phasellus fringilla tempus sapien quis mattis. Mauris a arcu gravida, sodales urna vitae, vestibulum ante. Cras elementum pretium egestas. Nullam scelerisque dignissim iaculis. Duis nec nibh venenatis, laoreet lorem nec, pellentesque nibh. Phasellus ultricies dui id velit pellentesque laoreet. Maecenas et lectus imperdiet diam pellentesque maximus. Ut nunc sem, maximus cursus dapibus a, pulvinar facilisis purus. Sed interdum, eros sit amet dapibus pharetra, nibh diam efficitur lacus, et fringilla mi lectus a felis. Donec sit amet aliquet lacus. Pellentesque diam velit, semper at ante sed, placerat lacinia lacus. Maecenas quis justo interdum, bibendum nulla ac, euismod justo.',
        	'date' 			=>  \Carbon\Carbon::now()->addDays(5),
        	'location' 		=> 'Biodiversity Gallery',
        	'fair_id' 		=> $secondFair->id,
        	'event_type_id' => $exhibitionEventType->id
        ]);

        $sixthFairEvent = factory(FairEvent::class)->create([
        	'title' 		=> 'Growing Your Startup Idea',
        	'image' 		=> 'http://lorempixel.com/900/600/business/5/',
        	'description' 	=> 'Donec blandit sit amet erat a ornare. Vestibulum a massa at odio fringilla faucibus et vitae eros. Quisque cursus vitae lorem ac scelerisque. Donec ut justo orci. Phasellus fringilla tempus sapien quis mattis. Mauris a arcu gravida, sodales urna vitae, vestibulum ante. Cras elementum pretium egestas. Nullam scelerisque dignissim iaculis. Duis nec nibh venenatis, laoreet lorem nec, pellentesque nibh. Phasellus ultricies dui id velit pellentesque laoreet. Maecenas et lectus imperdiet diam pellentesque maximus. Ut nunc sem, maximus cursus dapibus a, pulvinar facilisis purus. Sed interdum, eros sit amet dapibus pharetra, nibh diam efficitur lacus, et fringilla mi lectus a felis. Donec sit amet aliquet lacus. Pellentesque diam velit, semper at ante sed, placerat lacinia lacus. Maecenas quis justo interdum, bibendum nulla ac, euismod justo.',
        	'date' 			=>  \Carbon\Carbon::now()->addDays(5),
        	'location' 		=> 'Farnia #6 Meeting Room',
        	'fair_id' 		=> $thirdFair->id,
        	'event_type_id' => $seminarEventType->id
        ]);

        $seventhFairEvent = factory(FairEvent::class)->create([
        	'title' 		=> 'Workshop: Selling Your Idea Successfully',
        	'image' 		=> 'http://lorempixel.com/900/600/business/3/',
        	'description' 	=> 'Donec blandit sit amet erat a ornare. Vestibulum a massa at odio fringilla faucibus et vitae eros. Quisque cursus vitae lorem ac scelerisque. Donec ut justo orci. Phasellus fringilla tempus sapien quis mattis. Mauris a arcu gravida, sodales urna vitae, vestibulum ante. Cras elementum pretium egestas. Nullam scelerisque dignissim iaculis. Duis nec nibh venenatis, laoreet lorem nec, pellentesque nibh. Phasellus ultricies dui id velit pellentesque laoreet. Maecenas et lectus imperdiet diam pellentesque maximus. Ut nunc sem, maximus cursus dapibus a, pulvinar facilisis purus. Sed interdum, eros sit amet dapibus pharetra, nibh diam efficitur lacus, et fringilla mi lectus a felis. Donec sit amet aliquet lacus. Pellentesque diam velit, semper at ante sed, placerat lacinia lacus. Maecenas quis justo interdum, bibendum nulla ac, euismod justo.',
        	'date' 			=>  \Carbon\Carbon::now()->addDays(5),
        	'location' 		=> 'Decca Board Room',
        	'fair_id' 		=> $thirdFair->id,
        	'event_type_id' => $workShopEventType->id
        ]);

        $eightFairEvent = factory(FairEvent::class)->create([
        	'title' 		=> 'Temwork, An Essential Part Of Your Work Life',
        	'image' 		=> 'http://lorempixel.com/900/600/business/8/',
        	'description' 	=> 'Donec blandit sit amet erat a ornare. Vestibulum a massa at odio fringilla faucibus et vitae eros. Quisque cursus vitae lorem ac scelerisque. Donec ut justo orci. Phasellus fringilla tempus sapien quis mattis. Mauris a arcu gravida, sodales urna vitae, vestibulum ante. Cras elementum pretium egestas. Nullam scelerisque dignissim iaculis. Duis nec nibh venenatis, laoreet lorem nec, pellentesque nibh. Phasellus ultricies dui id velit pellentesque laoreet. Maecenas et lectus imperdiet diam pellentesque maximus. Ut nunc sem, maximus cursus dapibus a, pulvinar facilisis purus. Sed interdum, eros sit amet dapibus pharetra, nibh diam efficitur lacus, et fringilla mi lectus a felis. Donec sit amet aliquet lacus. Pellentesque diam velit, semper at ante sed, placerat lacinia lacus. Maecenas quis justo interdum, bibendum nulla ac, euismod justo.',
        	'date' 			=>  \Carbon\Carbon::now()->addDays(5),
        	'location' 		=> 'Farnia #1 Meeting Room',
        	'fair_id' 		=> $thirdFair->id,
        	'event_type_id' => $seminarEventType->id
        ]);

        // Speakers
        
        $firstSpeaker = factory(Speaker::class)->create([
        	'name' 			=> 'Lincoln Barret',
        	'picture' 		=> 'https://cdn.pixabay.com/photo/2015/01/08/18/29/entrepreneur-593358_1280.jpg',
        	'description' 	=> 'Cras at lacus sem. Maecenas elementum laoreet sapien, nec finibus libero vehicula sit amet. Quisque sit amet ante nibh. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nullam iaculis iaculis viverra. Nullam at placerat turpis, et suscipit velit. Fusce nec nisi purus.',
        	'fair_event_id' => $sixthFairEvent->id
        ]);

        $secondSpeaker = factory(Speaker::class)->create([
        	'name' 			=> 'Marianne Royston',
        	'picture' 		=> 'https://cdn.pixabay.com/photo/2014/12/23/14/45/woman-578429_1280.jpg',
        	'description' 	=> 'Cras at lacus sem. Maecenas elementum laoreet sapien, nec finibus libero vehicula sit amet. Quisque sit amet ante nibh. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nullam iaculis iaculis viverra. Nullam at placerat turpis, et suscipit velit. Fusce nec nisi purus.',
        	'fair_event_id' => $sixthFairEvent->id
        ]);

        $thirdSpeaker = factory(Speaker::class)->create([
        	'name' 			=> 'Andrey Yordanov',
        	'picture' 		=> 'https://cdn.pixabay.com/photo/2016/06/05/01/42/african-american-1436663_1280.jpg',
        	'description' 	=> 'Cras at lacus sem. Maecenas elementum laoreet sapien, nec finibus libero vehicula sit amet. Quisque sit amet ante nibh. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nullam iaculis iaculis viverra. Nullam at placerat turpis, et suscipit velit. Fusce nec nisi purus.',
        	'fair_event_id' => $firstFairEvent->id
        ]);

        $fourthSpeaker = factory(Speaker::class)->create([
        	'name' 			=> 'Henry Benson',
        	'picture' 		=> 'https://cdn.pixabay.com/photo/2016/11/29/04/51/book-1867403_1280.jpg',
        	'description' 	=> 'Cras at lacus sem. Maecenas elementum laoreet sapien, nec finibus libero vehicula sit amet. Quisque sit amet ante nibh. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nullam iaculis iaculis viverra. Nullam at placerat turpis, et suscipit velit. Fusce nec nisi purus.',
        	'fair_event_id' => $fourthFairEvent->id
        ]);

        // News
        
        $fairs = Fair::all()->lists('id');
		factory(News::class, 100)->create([
			'fair_id' => $fairs->first()
		])->each(function (News $news) use ($fairs) {
			$news->fair_id = $fairs->random();
			$news->save();
		});

		// Stands
		
		factory(Stand::class, 200)->create([
			'fair_id' => $fairs->first()
		])->each(function (Stand $stand) use ($fairs) {
			$stand->fair_id = $fairs->random();
			$stand->save();
		});
    }
}
