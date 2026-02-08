<?php

// connecting with the database
require_once '../db_connect.php';

#Inserting default Project users -> Bishal Bhatta, Chiranji Bista, Cretika chand, Dinesh Thagunna, Madan budha, Prabhat Thagunna.
try {
    $sql = "INSERT INTO users (name, email, password, photo, gender, phone, address) VALUES
                    ('Prabhat Thagunna', 'prabhatthagunna@gmail.com', 'password123', NULL, 'male', '9812045678', 'Mahendranagar, Kanchanpur, Nepal'),
                    ('Dinesh Thagunna', 'dineshthagunna@gmail.com', 'password123', NULL, 'male', '9824456789', 'Mahendranagar, Kanchanpur, Nepal'),
                    ('Cretika Chand', 'cretikachand@gmail.com', 'password123', NULL, 'female', '9838567890', 'Mahendranagar, Kanchanpur, Nepal'),
                    ('Chiranjibi Bista', 'chiranjibibista@gmail.com', 'password123', NULL, 'male', '9845678901', 'Mahendranagar, Kanchanpur, Nepal'),
                    ('Madan Budha', 'madanbudha@gmail.com', 'password123', NULL, 'male', '9856780102', 'Mahendranagar, Kanchanpur, Nepal'),
                    ('Bishal Bhatta', 'bishalbhatta@gmail.com', 'password123', NULL, 'male', '9837890123', 'Mahendranagar, Kanchanpur, Nepal')";

    $conn->query($sql);
    echo "<br>Demo User Data Inserted Successfully...";

} catch (Exception $e) {
    die("<b>Error while inserting User Demo records: </b>" . $e->getMessage());
}

#Instering Dummy blogs..
try {

    $sql = "INSERT INTO blogs (title, blogContent, photo, categoryId, userId) VALUES
-- 1
               (
               'How Artificial Intelligence Is Changing Everyday Life',
               'In 2026, Artificial Intelligence is no longer a tool you visit on a website. Instead, it has become an ambient layer of existence. We live in the age of the Personal AI Agent. These agents do not just answer questions; they anticipate needs. For example, your home system knows your schedule and pre-cools your living space using renewable energy credits it negotiated on your behalf during off-peak hours.

               In the realm of transportation, AI-driven traffic management has nearly eliminated the traditional rush hour in major cities. By communicating directly with autonomous vehicles and smart stoplights, the system creates a fluid flow of movement that saves billions of gallons of fuel annually. Even shopping has been transformed. Predictive logistics mean that the items you need are often shipped to a local hub before you even click buy, as algorithms analyze your consumption patterns with startling accuracy. 

               In healthcare, AI diagnostics have become so advanced that they can detect diseases at their earliest stages, often before symptoms even appear. This has led to a significant increase in life expectancy and quality of life. However, this new world also raises important ethical questions about privacy, job displacement, and the digital divide. As we navigate this AI-driven future, it is crucial to ensure that the benefits are shared equitably across society.',
               '../uploads/first-blog-image.jpg', 1, 3
               ),

               -- 2
               (
               'Top Tech Skills Students Should Learn in 2026',
               'The job market of 2026 rewards those who can bridge the gap between human creativity and machine execution. While basic literacy in code remains helpful, the following skills are the new gold standard for students:

               AI Orchestration: This is the ability to connect multiple AI models to solve a single complex problem. It is less about writing every line of code and more about being a digital architect.

               Prompt Engineering and Refinement: Clear communication with machines is vital. Students must learn how to structure instructions to get high-quality, ethical, and bias-free outputs from large language models.

               Cyber-Physical Security: As our physical world (cars, pacemakers, power grids) becomes more connected, the ability to defend these systems against digital threats is one of the highest-paying fields.

               Data Ethics and Governance: With AI making more decisions, we need humans who understand the legal and moral implications of data usage. Knowing how to ensure a system is fair and transparent is a critical skill.', '../uploads/second-blog-image.jpg', 1, 5
               ),

               -- 3
               (
               'Simple Daily Habits for a Healthier Life',
               ' In a fast-paced digital world, health is maintained through small, repeatable actions. Physical and mental vitality in 2026 is often the result of intentional friction—choosing the harder path to keep the body engaged.

               The Morning Sunlight Anchor: Spending ten minutes outside within an hour of waking up regulates your circadian rhythm. This simple act of viewing natural light helps set your internal clock for better focus during the day and deeper sleep at night.

               Zone 2 Cardio: Engaging in steady-state exercise where you can still hold a conversation is the secret to longevity. Just thirty minutes of brisk walking or cycling daily strengthens the heart without overtaxing the nervous system.

               Protein-First Nutrition: To combat the muscle loss associated with sedentary lifestyles, many are focusing on hitting protein targets early in the day. This stabilizes blood sugar and prevents the energy crashes that lead to overeating later.

               Micro-Meditation: Taking just two minutes between meetings to practice deep breathing can lower your heart rate and reset your stress levels, preventing the cumulative burnout common in tech-heavy roles.
               ',
               '../uploads/third-blog-image.jpg', 2, 2
               ),

               -- 4
               (
               'How Screen Time Affects Mental and Physical Health',
               'Despite the benefits of technology, the human body was not designed to stare at a glowing rectangle for twelve hours a day. The consequences of excessive screen time are now well-documented in 2026.

               The Physical Toll
               Physically, we see a rise in Digital Eye Strain. Because we blink less when looking at screens, our eyes become dry and fatigued. Furthermore, the posture known as tech neck causes chronic tension in the shoulders and upper spine. This can lead to tension headaches and reduced lung capacity over time. The blue light emitted by screens also interferes with the production of melatonin, the hormone responsible for sleep. Even if you are in bed for eight hours, the quality of that sleep is diminished if a screen was used right before closing your eyes.

               The Mental Toll
               Mentally, the constant stream of notifications keeps our brains in a state of high alert, or hyper-vigilance. This constant switching of attention prevents Deep Work—the ability to focus intensely on a single task. Over time, this erodes our patience and our capacity for critical thinking. Socially, while we are more connected than ever, the quality of these interactions is often thin. Relying on digital likes rather than physical presence can lead to a sense of isolation and increased anxiety.',
               '../uploads/fourth-blog-image.jpg', 2, 6
               ),

               -- 5
               (
               'Hidden Travel Destination in Nepal You Must Visit',
               'Rara Lake is one of the most beautiful hidden destinations in Nepal. It is located in the remote far-western part of the country and is the largest lake in Nepal. The lake is surrounded by green hills and snow-capped mountains, which makes it look like a scene from a painting.

               Rara Lake is part of Rara National Park, which is home to many animals and birds. Visitors can enjoy the peaceful environment and fresh air. The lake is very calm, and during sunrise and sunset, the water reflects the mountains and sky, creating a breathtaking view. It is a perfect place for nature lovers and photographers.

               Getting to Rara Lake can be an adventure in itself. The roads are not very easy, and travelers often have to trek to reach the lake. This makes the journey exciting and rewarding. Along the way, you can see local villages, forests, and wildlife. The people living near the lake are friendly and welcome tourists warmly.

               Visitors can also enjoy activities like hiking around the lake, bird watching, and camping. Since the area is less crowded, it is an ideal spot for those who want to escape the busy city life. The serene environment helps you relax and connect with nature.

               Overall, Rara Lake is a hidden gem of Nepal. Its natural beauty, peaceful surroundings, and adventure opportunities make it a must-visit place for travelers. Anyone who loves nature and quiet places will find this destination unforgettable.
               ',
               '../uploads/fifth-blog-image.jpg', 3, 1
               ),

               -- 6
               (
               'Budget Travel Tips for Students and Young Travelers',
               'Nepal remains one of the most affordable destinations in 2026, but smart planning can help you stretch your budget even further without sacrificing the experience.

               Utilize Local Tech: Download ride-sharing apps like Pathao or InDrive. These are significantly cheaper than hailing street taxis and provide transparent pricing for travel within cities like Kathmandu and Pokhara.

               The Tea House Strategy: When trekking, stay in local tea houses. In many regions, if you eat your dinner and breakfast at the same lodge where you sleep, the room rate is often heavily discounted or even free.

               Travel during Shoulder Seasons: Instead of the peak months of October and April, visit in late February or September. You will find lower prices on domestic flights and accommodation, fewer crowds, and still have a high chance of clear mountain views.

               Eat the National Staple: Dal Bhat is the ultimate budget hack. Not only is it nutritious and filling, but most local places offer free refills of the rice and lentils. It is the fuel of the Himalayas for a reason.
               ',
               '../uploads/sixth-blog-image.jpg', 3, 4
               ),

               -- 7
               (
               'Traditional Nepali Foods Everyone Should Try Once',
               'Nepali cuisine is a vibrant tapestry of flavors influenced by the diverse geography of the plains, hills, and high mountains.

               Momos (The National Snack): These steamed or fried dumplings are the soul food of Nepal. Whether filled with minced meat, vegetables, or cheese, they are always served with a spicy tomato-based chutney (achar) that varies from one street stall to the next.

               Thakali Khana: This is the premium version of Dal Bhat, originating from the Thak Khola region. It features high-quality grains, aromatic ghee, and local herbs like Jimbu. It is often served with Dhido, a nutritious, thick porridge made from buckwheat or millet.

               Newari Samay Baji: A traditional platter from the Newar community of the Kathmandu Valley. It includes beaten rice (chiura), smoked buffalo meat (choila), spicy potato salad, and various beans. It is a flavor explosion that represents the rich culinary heritage of the valley.

               Sel Roti: A ring-shaped, sweet, deep-fried rice bread. It is crispy on the outside and soft on the inside. Usually prepared during festivals like Tihar, it is best enjoyed with a hot cup of Nepali milk tea or a spicy vegetable curry.
               ',
               '../uploads/seventh-blog-image.jpg', 4, 5
               ),

               -- 8
               (
               'Healthy Eating on a Budget: Simple Food Choices',
               'Here is the content for the final three topics from your list, maintaining the same conversational yet informative tone for 2026.

               1. Healthy Eating on a Budget: Simple Food Choices
               Many people believe that eating healthy requires a massive budget, but in 2026, the smartest eaters are going back to basics. High-quality nutrition is more about strategy than spending.

               Prioritize Plant Proteins: Lentils, chickpeas, and beans are significantly cheaper than meat and offer high fiber and protein. In Nepal and many other regions, these remain the backbone of a healthy, low-cost diet.

               The Power of Seasonal Produce: Buying fruits and vegetables that are currently in season ensures you get the highest nutrient density for the lowest price. Out-of-season imports are not only expensive but often lose nutrients during long-distance shipping.

               Bulk Buying Staples: Grains like brown rice, oats, and buckwheat have a long shelf life. Buying these in larger quantities reduces the cost per meal significantly.

               Minimize Ultra-Processed Snacks: While a bag of chips might seem cheap, it offers zero nutritional value. Replacing processed snacks with a handful of roasted peanuts or a piece of local fruit provides sustained energy for a fraction of the long-term health cost.
               ',
               '../uploads/eighth-blog-image.jpg', 4, 2
               ),

               -- 9
               (
               'How to Stay Focused While Studying in the Digital Age',
               'With AI and constant notifications competing for our attention, focus has become a superpower. Students in 2026 use specific techniques to reclaim their concentration.

               Monotasking over Multitasking: The brain cannot actually multitask; it just switches between tasks rapidly, which lowers IQ by up to 10 points. Focus on one subject for 25 to 50 minutes before taking a structured break.

               Environmental Design: Your physical space dictates your mental state. Keep your phone in a separate room while studying. The mere presence of a smartphone—even if it is turned off—has been shown to reduce cognitive capacity.

               Digital Minimalism Tools: Use browser extensions or app blockers that restrict access to social media during study hours. In 2026, many students use Deep Work playlists—low-frequency ambient sound or white noise—to drown out environmental distractions.

               The Pomodoro 2.0 Method: Work for 50 minutes, then take a 10-minute break that does not involve a screen. Stretching, grabbing water, or looking out a window helps the brain reset its focus battery.
               ',
               '../uploads/ninth-blog-image.jpg', 5, 6
               ),

               -- 10
               (
               'Online Learning vs Traditional Classrooms',
               'Education has changed a lot in recent years. Online learning allows students to study from anywhere using the internet. You can learn at your own pace and access lessons and resources whenever you want.

               Traditional classrooms provide face-to-face interaction with teachers and classmates. This helps students ask questions, discuss ideas, and understand subjects better through direct communication.

               Both methods have their advantages and disadvantages. Online learning is flexible and convenient, but it may lack personal interaction. Traditional classrooms provide support and guidance, but they can be less flexible for students with busy schedules.

               Many students benefit from a combination of both. Using online resources to supplement classroom learning can make education more effective and enjoyable.
               ',
               '../uploads/tenth-blog-image.jpg', 5, 3
               ),

               -- 11
               (
               'Building a Balanced Lifestyle as a Student',
               'In 2026, being a successful student is no longer just about grades; it is about managing your energy across three main pillars: academic growth, physical health, and social connection.

               The 8-8-8 Rule: A balanced day consists of eight hours of sleep, eight hours of work or study, and eight hours of everything else—exercise, eating, and hobbies.

               Active Recovery: Instead of resting by scrolling on a phone, students are finding that active recovery—like a walk or a sport—clears mental fog much faster.

               Social Nutrition: Genuine face-to-face interaction is essential for mental health. Scheduling regular study groups or coffee dates helps prevent the isolation that often comes with digital learning.
               ',
               '../uploads/eleventh-blog-image.jpg', 6, 1
               ),

               -- 12
               (
               'Morning Routines That Improve Productivity',
               'How you start your day determines your cognitive performance for the next twelve hours. High achievers in 2026 follow a science-backed sequence.

               Hydration and Light: Drinking water immediately upon waking and getting natural sunlight into your eyes triggers a healthy cortisol spike, waking up the brain naturally.

               The No-Phone Zone: Delaying phone usage for the first hour of the day prevents your brain from entering a reactive state. This keeps you in control of your own priorities.

               Eat the Frog: Tackle your most difficult or creative task first thing in the morning when your willpower is at its highest point.
               ',
               '../uploads/twelth-blog-image.jpg', 6, 4
               ),

               -- 13
               (
               'Why Web Series Are Replacing Traditional TV',
               'The shift from scheduled television to on-demand web series is nearly complete in 2026. The reasons are rooted in both technology and storytelling.

               Non-Linear Storytelling: Web series allow creators to tell complex, deep stories that do not have to fit into a strict 30 or 60-minute time slot.

               Global Accessibility: Platforms allow a series made in South Korea or Nepal to be watched instantly worldwide with high-quality AI-dubbing or subtitles, breaking down cultural barriers.

               Personalized Algorithms: Traditional TV forces you to watch what is on; web series platforms use data to recommend niche content that matches your specific interests perfectly.',
               '../uploads/thirteenth-blog-image.jpg', 7, 2
               ),

               -- 14
               (
               'Basic Money Management Tips for Beginners',
               'Managing money is an important skill that everyone should learn early. It helps you stay prepared for emergencies and plan for the future. Even small steps can make a big difference over time.

               The first step is to track your income and expenses. Write down every source of income and every expense. This helps you understand where your money goes and identify areas where you can save.

               Next, set a monthly budget. Allocate money for essentials like food, transport, and bills, and set aside a portion for savings. Avoid spending money on unnecessary things that you do not need.

               It is also important to save regularly. Start small if needed, even ten or twenty percent of your income can grow over time. Learning to manage money early builds financial habits that will benefit you in the long run.
               ',
               '../uploads/fourteenth-blog-image.png', 8, 5
               ),

               -- 15
               (
               'Amazing Scientific Discoveries That Changed the World',
               'Science continues to push the boundaries of what is possible. These discoveries have fundamentally altered human history.

               CRISPR and Gene Editing: The ability to precisely edit DNA has opened the door to curing genetic diseases that were once considered terminal.

               Nuclear Fusion Breakthroughs: Recent steps toward sustainable fusion energy promise a future of nearly limitless, clean power, potentially ending the global energy crisis.

               Neural Interfaces: The development of chips that allow the brain to communicate directly with computers is helping paralyzed individuals regain movement and communication.
               ',
               '../uploads/fifteenth-blog-image.jpg', 10, 6
               );
               ";

    $conn->query($sql);
    echo "<br>Demo Blog Data Inserted Successfully...";

} catch (Exception $e) {
    die("<b>Error while inserting Blog Demo records: </b>" . $e->getMessage());
}
