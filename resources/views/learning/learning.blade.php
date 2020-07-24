@extends('layouts.app')

@section('title', 'How to Study to Remember More | StemmaStudy')

@section('header')
<style>
    h3, h4 {
        color: var(--main);
    }

    p {
        font-size: 18px;
    }

    .raised-box {
        background-color: white;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-left: 3px solid var(--light-acc);
    }

    .raised-box li {
        margin-top: 10px;
    }

    .share-button {
        font-size: 30px;
        margin-left: 5px;
        margin-right: 5px;
    }

    .share-button:hover {
        opacity: .8;
    }

    .share-button .fa-facebook {
        color: #3b5998;
    }

    .share-button .fa-twitter {
        color: #1DA1F2;
    }

    .share-button .fa-google-plus {
        color: #db4a39;
    }

    .share-button .fa-linkedin {
        color: #0e76a8;
    }

    .share-button .fa-envelope {
        color: #28aa80;
    }
    
    .sources {
        display: none;
    }

    .view-sources:hover {
        cursor: pointer;
    }

</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-0">How to Study to Remember More</h1>
            <small>Approx. 5 minutes to read</small>
            <hr>
            <p>Much of our lives revolve around learning &ndash; and <em>many</em> years are spent attending school for the sole purpose it.</p>
            <p>Learning <em>well</em> earns us the right to attend better classes, to get into better colleges, or even land better jobs.</p>
            <p>Yet, this ability to learn effectively is often taken for granted and the best techniques for studying, that save us time and help us remember, are seldom discussed.</p>
            <p>This guide will introduce you to a few of the most powerful and practical ways to improve your studying so that you can understand, remember, and achieve more.</p>
            <div class="p-3 raised-box">
                <h4><b>What will you learn?</b></h4>
                <ul>
                    <li>
                        <b>Self-Explanation</b><br><em>Talking to yourself might make you feel crazy, but it will definitely make you smarter.</em>
                    </li>
                    <li>
                        <b>Testing</b><br><em>Why tests can be more than simply assessments of learning.</em>
                    </li>
                    <li>
                        <b>Spacing</b><br><em>Some forgetting can be a good thing. Make time your ally.</em>
                    </li>
                    <li>
                        <b>Sleep</b><br><em>Why you should get more of it and what to do every night before you do.</em>
                    </li>
                    <li>
                        <b>Structure</b><br><em>How connecting ideas can make your study 3 times as effective.</em>
                    </li>
                    <li>
                        <b>Mindset</b><br><em>How to stay motivated and see difficulty as a challenge and not an obstacle.</em>
                    </li>
                </ul>
            </div>
            <hr>
            <h3><b>Self-Explanation</b></h3>
            <p>Self-explanation occurs when we explain a text to ourselves as we read it or recite the steps we are taking while solving a problem.</p>
            <p>For example, you would be engaging in self-explanation if, at the end of each section of this guide, you stopped to ask yourself, "What did I just read?" and summarized the content in your own words.</p>
            <p>This type of self-explanation has been shown to lead to <em>better solutions</em> while problem-solving as well as an <em>increased understanding</em> of a text when reading</p>
            <p>Self-explanations are even <em>more</em> effective when they go beyond the information presented in a text by further elaborating or making inferences about the material. </p>
            <p>You might engage in this higher form of self-explanation while reading this guide by asking and inferring answers to questions like "How can I make use of this technique?" or "Why does this technique work so well?".<sup>[1]</sup></p>
            <hr>
            <h3><b>Testing</b></h3>
            <p>People often think of tests and quizzes as mere assessments of learning and that the only good (or bad) that comes from taking them is knowledge of a grade.</p>
            <p>This isn't true!</p>
            <p>When we take a test, we are forced to retrieve information from memory without the ability to use an external source of information like our notes. Thus, our brains have to work a bit harder to find the answers. This extra effort strengthens the memory so that the brain doesn't have to work as hard in the future.</p>
            <p>We can make use of this testing effect in our study habits by taking practice tests, completing end-of-chapter questions, or by simply using flashcards.<sup>[2]</sup></p>
            <hr>
            <h3><b>Spacing</b></h3>
            <p>Everyone knows that learning things well takes time. We usually need to review information more than once before we can recall it perfectly without using our notes.</p>
            <p>One obvious way to improve memory, though not always feasible, would be to spend more time in review.</p>
            <p>What is less obvious is that the way we <em>schedule</em> this review time is crucially important.</p>
            <p>Many students often choose to study one concept at a time by reciting or rereading the material in back-to-back repetitions until it feels familiar. This is an ineffective strategy for long-term memory.</p>
            <p>If we reread something immediately, our brains don't have to do any work with the information. It's all already there!</p>
            <p>Instead, it is better to spread out our exposure to the material across more time. Then, when we return to the material, our brains draw up the memories of the last time we saw it, which strengthens them.</p>
            <p>This <em>spacing effect</em> is amplified when combined with the <em>testing effect</em> discussed earlier. Instead of simply returning to reread the material after some time has passed, try quizzing yourself on it first.<sup>[3]</sup></p>
            <div class="p-3 raised-box">
                <h4><b>Remember This When Cramming</b></h4>
                <p>It's an hour before the test. You don't feel like you've studied enough to fully grasp everything on the test, so you're frantically shuffling through your flashcards.</p>
                <p>In the interest of time, you decide to drop a few of them that you think you know well. You also drop a few that you think are too difficult to learn in such a short timeframe. This way, you believe you can get the most out of your cramming.</p>
                <p>Bad idea.</p>
                <p>One study found that we often make poor decisions about which cards to drop. Keeping the cards we know in the rotation might even be <em>beneficial</em> as it increases the spacing between the cards we do not know. <sup>[4]</sup></p>
            </div>
            <hr>
            <h3><b>Sleep</b></h3>
            <p>Sleep is often viewed as a time where nothing happens. But, during sleep, our brains are hard at work.</p>
            <p>While we sleep, our brains replay the events of the day and consolidate information into long-term memory. Sleeping has been shown to increase memory recall.<sup>[5]</sup></p>
            <p>When we don't get enough sleep, we hinder this consolidation process.</p>
            <p>Furthermore, our brains are constantly creating and integrating new neurons. A prolonged lack of either sleep or new learning experiences greatly reduces how many of these new neurons can survive.<sup>[6]</sup></p>
            <p>Don't starve your baby neurons.</p>
            <p>If you want a healthy, thriving brain, seek out new learning experiences every day for your brain to replay while you sleep and make sure to go to bed on time.</p>
            <hr>
            <h3><b>Structure</b></h3>
            <p>New material is easier to remember when the various information is all interconnected. In other words, when the material is well-organized.</p>
            <p>In one study, students were given 112 words to remember. Some of the students were given the words in random order, while others were given the words organized by category.</p>
            <p>After just one study session, the students given the organized words remembered <em>3.54 times</em> the number of words remembered by students given the random order!</p>
            <p>Furthermore, students given the organized words had <em>perfect</em> recall of all 112 words by a 3rd study session compared to a measly 52.8 average words recalled by the students given the randomized words.<sup>[7]</sup></p>
            <img class="shadow" src="{{ asset('/image/Organized_Vs_Random.png')}}" style="max-width: 100%;width: 500px;margin: 30px auto;display: block;" />
            <p>Information is not always delivered to us in the most organized manner. However, the best students spontaneously organize information as they get it by connecting the new information to other information they are learning or already know.</p>
            <p>Think of forming connections between ideas as creating mental pathways &ndash; the more connected an idea is to other information you know, the more likely you'll be able to find a pathway to reach it during a test.<sup>[8]</sup></p>
            <p>Connections can be made in all sorts of ways, such as by making categories, timelines, flow charts, or other diagrams out of the information you are trying to learn.</p>
            <hr>
            <h3><b>Mindset</b></h3>
            <p>What you believe about your abilities and the nature of intelligence can have a drastic impact on your performance in school and other learning activities.</p>
            <p>If you believe, for example, that you aren't a "math person" and that intellectual ability is mostly innate, then you have fallen victim to a <em>fixed mindset</em>.</p>
            <p>Individuals with a fixed mindset blame mistakes on a lack of ability and frequently avoid challenges, preferring easy tasks with which they know they can succeed.</p>
            <p>In contrast, a <em>growth mindset</em> occurs when you believe that your abilities and intelligence can be cultivated and grown.</p>
            <p>Individuals with a growth mindset seek out more challenges and see mistakes as opportunities for learning and growth. They will try new strategies when they fail or seek help from others.</p>
            <p>When individuals develop a growth mindset, they achieve more and even express more enjoyment of courses.<sup>[9]</sup></p>
            <p>So, when you encounter difficulty in your studies, remember that it isn't because you are incapable of understanding the material. Rather, it is just that you aren't there <em>yet</em>.</p>
            <hr>
            <h2><b>Your Learning, Your Life</b></h2>
            <p>Our lives are all greatly influenced by what we choose to learn and remember. Whatever your passions and goals, use these techniques to learn, and <em>become</em>, more.</p>
            <div class="p-3 raised-box">
                <h4><b>Summary</b></h4>
                <ul>
                    <li>
                        <b>Self-Explanation</b><br><em>Explain to yourself what you are reading or recite the steps you take as you solve a problem.</em>
                    </li>
                    <li>
                        <b>Testing</b><br><em>Quiz yourself. Try to remember concepts before looking at your notes.</em>
                    </li>
                    <li>
                        <b>Spacing</b><br><em>Don't review the same thing back-to-back. Let some time pass.</em>
                    </li>
                    <li>
                        <b>Sleep</b><br><em>Your brain replays the day's events as you sleep. Give it something to work on every day.</em>
                    </li>
                    <li>
                        <b>Structure</b><br><em>Organize and make connections between ideas you are learning.</em>
                    </li>
                    <li>
                        <b>Mindset</b><br><em>Your knowledge and ability can be cultivated. Don't quit when it gets hard &ndash; find a new strategy.</em>
                    </li>
                </ul>
            </div>
            <div class="green my-2 view-sources d-inline-block">View Sources</div>
            <div class="sources">
                <ol>
                    <li>
                        deLeeuw, N., &amp; Chi, M. T. H. (2003). Self-explanation: Enriching a situation model or repairing a domain model? In G. M. Sinatra &amp; P. R. Pintrich (Eds.), <em>Intentional conceptual change</em> (pp. 55–78). Mahwah, NJ: Lawrence Erlbaum Associates, Inc
                    </li>
                    <li>
                        Roediger, H. L., &amp; Butler, A. C. (2011). The critical role of retrieval practice in long-term retention. <em>Trends in Cognitive Sciences</em>, 15(1), 20–27. <a href="https://doi.org/10.1016/j.tics.2010.09.003" target="_blank">https://doi.org/10.1016/j.tics.2010.09.003</a>
                    </li>
                    <li>
                        Kang, S. H. K. (2016). Spaced Repetition Promotes Efficient and Effective Learning. <em>Policy Insights from the Behavioral and Brain Sciences</em>, 3(1), 12–19. <a href="https://doi.org/10.1177/2372732215624708" target="_blank">https://doi.org/10.1177/2372732215624708</a>
                    </li>
                    <li>
                        Kornell, N., &amp; Bjork, R. A. (2008). Optimising self-regulated study: The benefits&mdash;and costs&mdash;of dropping flashcards. <em>Memory</em>, 16(2), 125–136. <a href="https://doi.org/10.1080/09658210701763899" target="_blank">https://doi.org/10.1080/09658210701763899</a>
                    </li>
                    <li>
                        Ellenbogen, J. M., Payne, J. D., &amp; Stickgold, R. (2006). The role of sleep in declarative memory consolidation: passive, permissive, active or none? <em>Current Opinion in Neurobiology</em>, 16(6), 716–722. <a href="https://doi.org/10.1016/j.conb.2006.10.006" target="_blank">https://doi.org/10.1016/j.conb.2006.10.006</a>
                    </li>
                    <li>
                        Hairston, I. S., Little, M. T. M., Scanlon, M. D., Barakat, M. T., Palmer, T. D., Sapolsky, R. M., &amp; Heller, H. C. (2005). Sleep Restriction Suppresses Neurogenesis Induced by Hippocampus-Dependent Learning. <em>Journal of Neurophysiology</em>, 94(6), 4224–4233. <a href="https://doi.org/10.1152/jn.00218.2005" target="_blank">https://doi.org/10.1152/jn.00218.2005</a>
                    </li>
                    <li>
                        Bower, G. H., Clark, M. C., Lesgold, A. M., &amp; Winzenz, D. (1969). Hierarchical retrieval schemes in recall of categorized word lists. <em>Journal of Verbal Learning and Verbal Behavior</em>, 8(3), 323–343. <a href="https://doi.org/10.1016/s0022-5371(69)80124-6" target="_blank">https://doi.org/10.1016/s0022-5371(69)80124-6</a>
                    </li>
                    <li>
                        Britton, B. K., Stimson, M., Stennett, B., &amp; Gülgöz, S. (1998). Learning from instructional text: Test of an individual-differences model. <em>Journal of Educational Psychology</em>, 90(3), 476–491. <a href="https://doi.org/10.1037/0022-0663.90.3.476" target="_blank">https://doi.org/10.1037/0022-0663.90.3.476</a>
                    </li>
                    <li>
                        Boaler, J. O. (2013). Ability and Mathematics: the mindset revolution that is reshaping education. <em>FORUM</em>, 55(1), 143. <a href="https://doi.org/10.2304/forum.2013.55.1.143" target="_blank">https://doi.org/10.2304/forum.2013.55.1.143</a> 
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="text-center mt-5 mb-4 px-2">
    <h3 class="text-body">Learn Something?</h3>
    <h5>Help make the world smarter by sharing it with the people you care about.</h5>
    <a class="share-button unlink" href="http://www.facebook.com/sharer.php?u=https://stemmastudy.com/learn" target="_blank">
        <i class="fab fa-facebook"></i>
    </a>
    <a class="share-button unlink" href="https://plus.google.com/share?url=https://stemmastudy.com/learn" target="_blank">
        <i class="fab fa-google-plus"></i>
    </a>
    <a class="share-button unlink" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=https://stemmastudy.com/learn" target="_blank">
        <i class="fab fa-linkedin"></i>
    </a>
    <a class="share-button unlink" href="https://twitter.com/share?url=https://stemmastudy.com&amp;text=How%20to%20learn%20and%20remember%20more&amp;hashtags=learning" target="_blank">
        <i class="fab fa-twitter"></i>
    </a>
    <a class="share-button unlink" href="mailto:?Subject=How to Learn and Remember More&amp;Body=Thought%20you%20might%20want%20to%20try%20these%20study%20techniques%20 https://stemmastudy.com/learn" target="_blank">
        <i class="fas fa-envelope"></i>
    </a>
</div>

@guest
<div class="d-flex justify-content-center py-5 px-3 mt-5 you-are-container">
    <div class="you-are text-center">
        <h1>Forget Flashcards as You Know Them</h1>
        <h4 class="text-body">Try StemmaStudy free for 30 days and start understanding and remembering more.</h4>
        <a href="{{route('register')}}" class="btn btn-light mt-3">Start my Free Trial <i class="fas fa-angle-double-right"></i></a>
    </div>
</div>
@endguest

@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('.view-sources').click(function(){
            $('.sources').slideToggle();
        });
    });
</script>
@endsection