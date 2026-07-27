<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use App\Models\Hero;
use App\Models\About;
use App\Models\Service;
use App\Models\Project;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\PricingPlan;
use App\Models\Faq;
use App\Models\Testimonial;
use App\Models\TeamMember;
use App\Models\Blog;
use App\Models\ContactMessage;
use App\Models\NewsletterSubscriber;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Admin User
        $this->call(AdminSeeder::class);

        // 2. Seed Settings
        $settings = [
            'site_name' => 'Storyloom',
            'site_logo_light' => 'assets/img/logo-primary-light.png',
            'site_emblem' => 'assets/img/logo-emblem.png',
            'site_wordmark' => 'assets/img/logo-wordmark.png',
            'site_favicon' => 'assets/img/favicon.png',
            'contact_phone' => '+91 99999 99999',
            'contact_email' => 'hello@storyloom.in',
            'contact_whatsapp' => '919999999999',
            'contact_address' => 'New Delhi, India',
            'social_instagram' => 'https://www.instagram.com/storyloombooks/',
            'instagram_username' => 'storyloombooks',
            'copyright_text' => 'Storyloom. Every story belongs to its family.',
            'seo_title' => 'Storyloom — The Story Only You Could Give',
            'seo_description' => 'Storyloom transforms your memories into a hand-illustrated keepsake storybook — a one-of-a-kind gift for the people who shaped your life. Crafted in India, treasured forever.',
            'seo_keywords' => 'personalized storybook, keepsake books, customized gifts, illustrated storybook, India gifts, anniversaries, birthdays',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 3. Seed Hero Section
        Hero::truncate();
        Hero::create([
            'heading' => 'The story only <em>you</em> could give.',
            'subheading' => 'Personalised keepsake storybooks',
            'description' => 'We transform your memories into a beautifully illustrated keepsake book — every page painted around your people, your places, and the moments that made you a family.',
            'button_text' => 'Begin Your Story',
            'button_link' => '/begin',
            'background_image' => 'assets/img/spread-bench-dusk.webp',
            'hero_image' => 'assets/img/logo-emblem.png',
        ]);

        // 4. Seed About Section
        About::truncate();
        About::create([
            'heading' => 'We exist because memories deserve better than a <em>camera roll.</em>',
            'description' => "Families capture more of their lives than ever — and revisit almost none of it. Storyloom turns those scattered moments into the one object a family opens again and again: a book that holds a real relationship, a real home, a real chapter of a life.\n\nThe name is the method. A loom weaves loose threads into something whole.",
            'image' => 'assets/img/spread-walk-together.webp',
            'experience_years' => 5,
            'skills' => ['Creative Writing', 'Fine Art Illustration', 'Graphic Layout', 'Archival Bookmaking'],
            'statistics' => [
                ['number' => '1,200+', 'label' => 'Stories Painted'],
                ['number' => '100%', 'label' => 'Illustrated by Hand'],
                ['number' => '15+', 'label' => 'Master Artisans'],
            ]
        ]);

        // 5. Seed Services (Occasions list)
        Service::truncate();
        $services = [
            ['title' => 'Anniversaries', 'description' => 'Woven around the years you built together.', 'icon' => 'calendar', 'display_order' => 1],
            ['title' => 'Birthdays', 'description' => 'A lifetime of memories bounds in one place.', 'icon' => 'gift', 'display_order' => 2],
            ['title' => 'Farewells', 'description' => 'A slice of home to take across the world.', 'icon' => 'globe', 'display_order' => 3],
            ['title' => 'Just Because', 'description' => 'Simply saying what they mean to you, today.', 'icon' => 'heart', 'display_order' => 4],
        ];
        foreach ($services as $srv) {
            Service::create($srv + ['status' => 'active']);
        }

        // 6. Seed Projects & Portfolio (Sample illustrated spreads)
        Project::truncate();
        $projects = [
            [
                'title' => 'The flat where it all began',
                'slug' => 'the-flat-where-it-all-began',
                'category' => 'Home',
                'description' => 'Illustrated spread of a sunlit living room with an open book and a cup of tea on the table.',
                'images' => ['assets/img/spread-home-morning.webp'],
                'client_name' => 'The Mehra Family',
                'project_url' => '',
                'completion_date' => '2026-01-15',
                'technologies_used' => 'Watercolors, Ink',
                'featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'The evening walk, every single day',
                'slug' => 'the-evening-walk-every-single-day',
                'category' => 'Routine',
                'description' => 'Illustration of a couple walking down a flowering street at golden hour.',
                'images' => ['assets/img/spread-flower-street.webp'],
                'client_name' => 'Aakash & Riya',
                'project_url' => '',
                'completion_date' => '2026-03-10',
                'technologies_used' => 'Gouache, Digital Touchup',
                'featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'One plate, two forks — always',
                'slug' => 'one-plate-two-forks-always',
                'category' => 'Inside Jokes',
                'description' => 'Close-up illustration of two hands sharing a plate of fries at a café table.',
                'images' => ['assets/img/spread-shared-fries.webp'],
                'client_name' => 'Kabir & Neil',
                'project_url' => '',
                'completion_date' => '2026-05-22',
                'technologies_used' => 'Ink, Pastel',
                'featured' => true,
                'status' => 'published',
            ]
        ];
        foreach ($projects as $proj) {
            Project::create($proj);
        }

        // 7. Seed Portfolios (Occasion-targeted story cards)
        Portfolio::truncate();
        $portfolios = [
            ['title' => 'For Your Wife', 'category' => 'anniversaries · birthdays', 'description' => 'A golden-hour memory of quiet connection.', 'thumbnail' => 'assets/img/spread-bench-sunset.webp', 'gallery' => [], 'status' => 'published'],
            ['title' => 'For Your Husband', 'category' => 'anniversaries · milestones', 'description' => 'Remembering the corner table at your favourite café.', 'thumbnail' => 'assets/img/spread-cafe-window.webp', 'gallery' => [], 'status' => 'published'],
            ['title' => 'For Mom', 'category' => 'Mother\'s Day · birthdays', 'description' => 'The morning trips to the flower mandi.', 'thumbnail' => 'assets/img/spread-street-morning.webp', 'gallery' => [], 'status' => 'published'],
            ['title' => 'For Dad', 'category' => 'retirement · Father\'s Day', 'description' => 'His favourite bench overlooking the valley.', 'thumbnail' => 'assets/img/spread-alone-bench.webp', 'gallery' => [], 'status' => 'published'],
            ['title' => 'For Your Sister', 'category' => 'Raksha Bandhan · birthdays', 'description' => 'Staying underwater in the pool for as long as possible.', 'thumbnail' => 'assets/img/book2-spread-pool.webp', 'gallery' => [], 'status' => 'published'],
            ['title' => 'For Grandparents', 'category' => 'anniversaries · child\'s birth', 'description' => 'A warm family home full of evening light.', 'thumbnail' => 'assets/img/spread-home-evening.webp', 'gallery' => [], 'status' => 'published'],
        ];
        foreach ($portfolios as $port) {
            Portfolio::create($port);
        }

        // 8. Seed Products (Book Formats / Packages)
        Product::truncate();
        $products = [
            [
                'name' => 'Classic Keepsake Edition',
                'slug' => 'classic-keepsake-edition',
                'description' => 'A beautiful handbound A4 hardback book featuring up to 10 fully customized illustrations telling your family story. Printed on thick, archival-grade fine art paper.',
                'price' => 14999.00,
                'discount_price' => 12999.00,
                'main_image' => 'assets/img/spread-home-morning.webp',
                'gallery_images' => ['assets/img/spread-home-morning.webp', 'assets/img/spread-shared-fries.webp'],
                'category' => 'Hardcover',
                'status' => 'published'
            ],
            [
                'name' => 'Grand Heirloom Edition',
                'slug' => 'grand-heirloom-edition',
                'description' => 'Our premium large-format album featuring 16 hand-painted spreads, rich textured fabric cover with gold foil lettering, and a matching custom-built presentation box.',
                'price' => 24999.00,
                'discount_price' => null,
                'main_image' => 'assets/img/spread-bench-dusk.webp',
                'gallery_images' => ['assets/img/spread-bench-dusk.webp', 'assets/img/spread-flower-street.webp'],
                'category' => 'Heirloom Boxed',
                'status' => 'published'
            ]
        ];
        foreach ($products as $prod) {
            Product::create($prod);
        }

        // 9. Seed Pricing Plans
        PricingPlan::truncate();
        $plans = [
            [
                'plan_name' => 'Classic',
                'price' => 14999.00,
                'duration' => 'onwards',
                'features' => [
                    'Original story, written from your memories',
                    '12 fully illustrated spreads (24 pages)',
                    'Hardcover, archival paper',
                    'Two review rounds before print',
                    'Keepsake box & gift wrapping',
                    'Delivery across India'
                ],
                'button_text' => 'Begin Your Story',
                'button_url' => '/begin',
                'popular_plan' => false,
                'status' => 'active'
            ],
            [
                'plan_name' => 'Deluxe',
                'price' => 21999.00,
                'duration' => 'onwards',
                'features' => [
                    'Everything in Classic',
                    '16 illustrated spreads (32 pages)',
                    'Illustrated end-papers with your details',
                    'Foil-stamped title on the cover',
                    'Letterpressed message card, sealed',
                    'Priority crafting timeline'
                ],
                'button_text' => 'Begin Your Story',
                'button_url' => '/begin',
                'popular_plan' => true,
                'status' => 'active'
            ],
            [
                'plan_name' => 'Heirloom',
                'price' => 34999.00,
                'duration' => 'onwards',
                'features' => [
                    'Everything in Deluxe',
                    'Linen-bound cover with slipcase',
                    'A second, identical family copy',
                    'Signed print of your favourite spread',
                    'Unlimited review rounds',
                    'Worldwide express delivery included'
                ],
                'button_text' => 'Begin Your Story',
                'button_url' => '/begin',
                'popular_plan' => false,
                'status' => 'active'
            ]
        ];
        foreach ($plans as $plan) {
            PricingPlan::create($plan);
        }

        // 10. Seed FAQs
        Faq::truncate();
        $faqs = [
            ['question' => 'What if I\'m not a writer?', 'answer' => 'You don\'t need to be. You share memories the way you\'d tell them to a friend — scattered, unpolished, out of order. Our writers shape them into a story. Most of our favourite books began as voice notes.', 'display_order' => 1, 'status' => 'active'],
            ['question' => 'Can I review the book before it\'s printed?', 'answer' => 'Always. You\'ll see the story, then every illustrated spread, before anything goes to print. Refinement rounds are built into the process — nothing is final until you say it is.', 'display_order' => 2, 'status' => 'active'],
            ['question' => 'How long does a Storyloom take?', 'answer' => 'Most books take three to five weeks from first conversation to delivery. Working towards a date? Tell us — we plan every book backwards from the moment it needs to be opened.', 'display_order' => 3, 'status' => 'active'],
            ['question' => 'Can pets, grandparents — everyone — be in it?', 'answer' => 'Yes — the dog, the grandparents, the neighbour who\'s basically family, the exact balcony with the exact plants. If they belong in your story, they belong in the book.', 'display_order' => 4, 'status' => 'active'],
        ];
        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        // 11. Seed Testimonials
        Testimonial::truncate();
        $testimonials = [
            [
                'client_name' => 'Anjali Sharma',
                'company' => '',
                'designation' => 'A daughter\'s gift, for her mother\'s 60th',
                'image' => '',
                'review' => 'My mother read it aloud twice, cried both times, and now it lives on her bedside table. Nothing I\'ve ever given her has come close.',
                'rating' => 5,
                'status' => 'active'
            ],
            [
                'client_name' => 'Rohan Mehta',
                'company' => '',
                'designation' => 'An anniversary Storyloom',
                'image' => '',
                'review' => 'We gave it to my husband on our tenth anniversary. Watching him turn the pages of our own story — I\'ll never forget his face.',
                'rating' => 5,
                'status' => 'active'
            ],
            [
                'client_name' => 'Vikram Aditya',
                'company' => '',
                'designation' => 'A farewell gift, between best friends',
                'image' => '',
                'review' => 'My best friend moved across the world. Now our whole childhood sits on his shelf in Toronto, and he says he reads it when he misses home.',
                'rating' => 5,
                'status' => 'active'
            ],
        ];
        foreach ($testimonials as $test) {
            Testimonial::create($test);
        }

        // 12. Seed Team Members
        TeamMember::truncate();
        TeamMember::create([
            'name' => 'Manan',
            'designation' => 'Founder & Creative Lead',
            'photo' => 'assets/img/logo-emblem.png',
            'social_links' => ['instagram' => 'https://www.instagram.com/storyloombooks/'],
            'description' => 'I started Storyloom after watching my mother re-read a forty-year-old letter until the folds wore through. We keep almost nothing now. I wanted to build the thing families keep.',
            'status' => 'active'
        ]);

        // 13. Seed Blogs
        Blog::truncate();
        Blog::create([
            'title' => 'What to give the person who says “don\'t get me anything.”',
            'slug' => 'what-to-give-the-person-who-says-dont-get-me-anything',
            'featured_image' => 'assets/img/spread-bench-dusk.webp',
            'category' => 'gifts',
            'read_time' => '6',
            'short_description' => 'They mean it — they don\'t want more objects. Here\'s the three-year test every gift should pass, and the five kinds of gift that pass it.',
            'content' => '<p class="lead-in">There is a particular kind of person who, every single year, says the same sentence: <em>“Please, don\'t get me anything.”</em> Usually it\'s a parent. Sometimes it\'s the friend who already owns everything, or the partner who genuinely finds being celebrated a bit embarrassing.</p><p>Most gift guides treat this as an obstacle to route around. It isn\'t. It\'s the most useful piece of information they will ever give you — because they\'ve just told you exactly what kind of gift will fail.</p><h2 id="why">Why they actually say it</h2><p>They\'re not being modest, and they\'re not testing you. They\'re telling you something true: they have reached the stage of life where <strong>another object is a small burden.</strong> One more thing to find a place for. One more thing to dust, store, feel vaguely guilty about, and eventually give away.</p><p>So when you hand them a scented candle, a gadget, or a gift card, they perform the correct amount of delight and then quietly wonder where it will live. You both know it. That\'s the awkward beat in the room.</p><blockquote class="pull-quote">They don\'t want less from you. They want less <em>stuff</em> from you.</blockquote><p>Which leaves a genuinely interesting question: what can you give someone that doesn\'t add to the pile?</p><h2 id="test">The three-year test</h2><p>Before buying anything for this person, run it through one question:</p><div class="takeaway"><p class="tk-label"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 12.5l5 5L20 6.5"/></svg>The test</p><p><strong>In three years, will this still exist — and will they be glad it does?</strong> Both halves matter. Plenty of gifts survive three years in a cupboard without anyone being glad about it.</p></div><p>Almost everything fails this. Flowers fail in a week. Chocolates fail by Sunday. Electronics survive but get replaced, and nobody feels sentimental about a replaced charger. Even expensive gifts mostly fail, because price and meaning are unrelated variables that we keep confusing for each other.</p><p>What passes tends to fall into a short list.</p><h2 id="passes">What actually passes</h2><ul><li><strong>Something consumable and genuinely good.</strong> If you\'re going to give an object, give one designed to disappear — excellent coffee, the olive oil they\'d never buy themselves. It leaves no residue and no obligation.</li><li><strong>Something repaired.</strong> Take the watch that stopped in 2019, the chair with the wobbly leg, the photo with the torn corner — and quietly have it restored. You\'re not adding an object; you\'re returning one.</li><li><strong>Time, specifically scheduled.</strong> Not “we should have lunch sometime.” An actual date, booked, in the calendar, that you organised entirely.</li><li><strong>A letter that says the thing you\'ve never said.</strong> Nearly free. Devastating in the best way. Kept forever, usually in a drawer they can find in the dark.</li><li><strong>Their own story, given back to them.</strong> The rarest one, and the one that lands hardest — because it\'s the only gift on this list they could never buy for themselves.</li></ul><p>That last one deserves explaining, because it\'s the least obvious and the most reliable.</p><h2 id="specific">Specific beats expensive, every time</h2><p>Here\'s the pattern we see over and over: the gift people remember isn\'t the grandest one. It\'s the one that proved someone had been <em>paying attention.</em></p><p>Not “I know you like reading.” More like: <em class="said">I know you read the last page first, I know you fold the corner instead of using the bookmark I gave you, and I know you\'ve re-read the same novel every monsoon since 2011.</em></p><blockquote class="pull-quote">Generic love says “I appreciate you.” Specific love says “I was there, I noticed, and I remember.” <cite>Storyloom · Studio note</cite></blockquote><p>Specificity is why a two-rupee detail can outperform a twenty-thousand-rupee object. The chai stall you stopped at every evening. The nickname only your family uses. The way your father sits on exactly one corner of the sofa. These are the details that make someone put a hand over their mouth.</p><h2 id="start">How to actually pull it off</h2><p>The reason people default to candles isn\'t laziness — it\'s that “meaningful” feels like a lot of work when you have eleven days and no plan. So here\'s the smallest version that still works.</p><p><strong>Write down five things only you would know about them.</strong> Not achievements. Habits. The thing they always say. The place they always stop. The argument you\'ve had nine times about a restaurant order.</p><p>That list is the whole gift. Whether you turn it into a letter, a framed photograph, a dinner that recreates one of those five moments, or a book — the list is the part that carries the weight. Everything else is packaging.</p><figure class="article-figure plate" data-reveal><img src="assets/img/spread-shared-fries.webp" width="1100" height="1469" loading="lazy" alt="Illustration of two hands reaching for the same plate of fries at a café table"><figcaption>“one plate, two forks” — an actual page from an actual family\'s book</figcaption></figure><p>And if they still insist they don\'t want anything? Give it anyway. Nobody who has ever received the specific version has been annoyed about it. That\'s the one gift the sentence was never protecting them from.</p>',
            'meta_title' => 'What to Give the Person Who Says “Don\'t Get Me Anything” | Storyloom Journal',
            'meta_description' => 'The three-year test every gift should pass — and the five kinds of gift that pass it.',
            'keywords' => 'gift guides, family stories, keepsakes',
            'status' => 'published'
        ]);

        Blog::create([
            'title' => 'What to give the person who says “don\'t get me anything.”',
            'slug' => 'journal-dont-get-me-anything',
            'featured_image' => 'assets/img/spread-bench-dusk.webp',
            'category' => 'gifts',
            'read_time' => '6',
            'short_description' => 'They mean it — they don\'t want more objects. Here\'s the three-year test every gift should pass, and the five kinds of gift that pass it.',
            'content' => Blog::where('slug', 'what-to-give-the-person-who-says-dont-get-me-anything')->value('content'),
            'meta_title' => 'What to Give the Person Who Says “Don\'t Get Me Anything” | Storyloom Journal',
            'meta_description' => 'The three-year test every gift should pass — and the five kinds of gift that pass it.',
            'keywords' => 'gift guides, family stories, keepsakes',
            'status' => 'published'
        ]);

        // 14. Seed Contact Messages
        ContactMessage::truncate();
        ContactMessage::create([
            'name' => 'Divya K.',
            'email' => 'divya@example.com',
            'phone' => '9876543210',
            'subject' => 'Anniversary Gift Request',
            'message' => 'Hi, I want to make a book for my parents 25th anniversary. I have photos and stories ready. Let me know when we can speak!',
            'is_read' => false,
            'read_at' => null
        ]);

        // 15. Seed Newsletter Subscribers
        NewsletterSubscriber::truncate();
        NewsletterSubscriber::create(['email' => 'newsletter-demo@storyloom.in']);

        // 16. Seed Library Books
        \App\Models\LibraryBook::truncate();
        $libraryBooks = [
            [
                'title' => 'The First Home',
                'subtitle' => 'A birthday gift for Mansi',
                'type' => 'featured',
                'relation_tag' => 'For a wife',
                'occasion_tag' => 'Birthday',
                'spreads_count' => '15 spreads',
                'read_time' => '8 min read',
                'synopsis' => 'Their first flat had a leaking tap, one steel cup, and a view of every rooftop in the city. For Mansi\'s birthday, her husband turned their first year in their first home into a painted story — the morning chai, the evening walks, the plate of fries they still argue about.',
                'caption' => 'the actual cover — printed, bound, gifted',
                'cover_image' => 'assets/img/book1/cover.webp',
                'back_image' => 'assets/img/book1/back.webp',
                'pages_json' => array_map(function($i) {
                    $num = sprintf('%02d', $i);
                    return ['src' => "assets/img/book1/s{$num}.webp", 'alt' => "The First Home — spread {$i}"];
                }, range(1, 15)),
                'order' => 1,
                'status' => true,
            ],
            [
                'title' => 'Underwater, Together',
                'subtitle' => 'A rakhi gift for Chicky Didi',
                'type' => 'featured',
                'relation_tag' => 'For a sister',
                'occasion_tag' => 'Raksha Bandhan',
                'spreads_count' => '17 spreads',
                'read_time' => '9 min read',
                'synopsis' => 'Two kids, one landline, and a swim class neither of them wanted to attend. This Raksha Bandhan, instead of another gift, a brother bound twenty years of schemes, duets and dance routines into a book for his Chicky Didi — proof that some skills only work in pairs.',
                'caption' => 'the actual cover — a rakhi gift for Chicky Didi',
                'cover_image' => 'assets/img/book2/cover.webp',
                'back_image' => 'assets/img/book2/back.webp',
                'pages_json' => array_map(function($i) {
                    $num = sprintf('%02d', $i);
                    return ['src' => "assets/img/book2/s{$num}.webp", 'alt' => "Underwater, Together — spread {$i}"];
                }, range(1, 17)),
                'order' => 2,
                'status' => true,
            ],
            [
                'title' => 'The Moon Protector',
                'subtitle' => 'For a daughter',
                'type' => 'shelf',
                'relation_tag' => 'For a daughter · on the loom',
                'synopsis' => 'A bedtime adventure for the girl who asked if the moon follows her home.',
                'cover_image' => 'assets/img/spread-under-stars.webp',
                'order' => 3,
                'status' => true,
            ],
            [
                'title' => 'Letters From Grandma',
                'subtitle' => 'For a grandmother',
                'type' => 'shelf',
                'relation_tag' => 'For a grandmother · on the loom',
                'synopsis' => 'Sixty years of recipes, prayers, and Sunday letters, finally bound.',
                'cover_image' => 'assets/img/spread-street-morning.webp',
                'order' => 4,
                'status' => true,
            ],
            [
                'title' => 'Dad\'s Bicycle',
                'subtitle' => 'For a father',
                'type' => 'shelf',
                'relation_tag' => 'For a father · on the loom',
                'synopsis' => 'Every route he ever pedalled, retold by the boy on the back seat.',
                'cover_image' => 'assets/img/spread-alone-bench.webp',
                'order' => 5,
                'status' => true,
            ],
            [
                'title' => 'Our Little Explorer',
                'subtitle' => 'For a son',
                'type' => 'shelf',
                'relation_tag' => 'For a son · on the loom',
                'synopsis' => 'The first five years of a boy who never once sat still.',
                'cover_image' => 'assets/img/book2-page-dance.webp',
                'order' => 6,
                'status' => true,
            ],
        ];
        foreach ($libraryBooks as $lb) {
            \App\Models\LibraryBook::create($lb);
        }
    }
}
