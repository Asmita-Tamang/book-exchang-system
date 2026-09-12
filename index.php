
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Book Exchange System</title>

    <link rel="stylesheet" href="assets/css/index.css">
</head>

<body>

    <!-- ================= NAVBAR ================= -->

    <header class="navbar">

        <div class="logo">
            <a href="index.php">
                Book<span>Exchange</span>
            </a>
        </div>

        <nav class="nav-links">
            <a href="#about">About</a>
            <a href="#how-it-works">How It Works</a>
            <a href="#categories">Categories</a>
            <a href="auth/login.php" class="login-btn">Login</a>
            <a href="auth/register.php" class="register-btn">Register</a>
        </nav>

    </header>


    <!-- ================= HERO ================= -->

    <section class="hero">

        <div class="hero-content">

            <p class="hero-label">
                WELCOME TO BOOK EXCHANGE SYSTEM
            </p>

            <h1>
                Give Books a
                <span>New Story.</span>
            </h1>

            <p class="hero-description">
                Exchange the books you no longer need and discover
                stories waiting to be read. Connect with other readers
                and make every book's journey continue.
            </p>

            <div class="hero-buttons">

                <a href="auth/register.php" class="primary-btn">
                    Start Exchanging
                </a>

                <a href="#how-it-works" class="outline-btn">
                    How It Works
                </a>

            </div>

        </div>


        <!-- Hero Visual -->

        <div class="hero-visual">

            <div class="book-stack">

                <div class="book book-one">
                    <span>READ</span>
                </div>

                <div class="book book-two">
                    <span>SHARE</span>
                </div>

                <div class="book book-three">
                    <span>EXCHANGE</span>
                </div>

            </div>

            <div class="hero-circle"></div>

        </div>

    </section>


    <!-- ================= ABOUT ================= -->

    <section class="about" id="about">

        <div class="section-heading">

            <p>ABOUT THE PLATFORM</p>

            <h2>
                Books Should Be Read,<br>
                Not Forgotten.
            </h2>

        </div>


        <div class="about-container">

            <div class="about-text">

                <p>
                    Book Exchange System is a platform created for
                    readers who want to exchange non-academic books
                    with one another.
                </p>

                <p>
                    Instead of allowing books to sit unused on
                    shelves, users can list their books, discover
                    books they are interested in, and connect with
                    other readers for a direct exchange.
                </p>

            </div>


            <div class="about-features">

                <div class="feature">
                    <div class="feature-number">01</div>
                    <div>
                        <h3>Reuse Books</h3>
                        <p>
                            Give your unused books another reader.
                        </p>
                    </div>
                </div>

                <div class="feature">
                    <div class="feature-number">02</div>
                    <div>
                        <h3>Find New Stories</h3>
                        <p>
                            Discover books from other readers.
                        </p>
                    </div>
                </div>

                <div class="feature">
                    <div class="feature-number">03</div>
                    <div>
                        <h3>Connect Locally</h3>
                        <p>
                            Find readers and exchange books nearby.
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </section>


    <!-- ================= HOW IT WORKS ================= -->

    <section class="how-it-works" id="how-it-works">

        <div class="section-heading center">

            <p>THE PROCESS</p>

            <h2>
                How Book Exchange Works
            </h2>

            <span>
                Start exchanging books in a few simple steps.
            </span>

        </div>


        <div class="steps">

            <div class="step">

                <div class="step-top">
                    <span>01</span>
                </div>

                <h3>Create an Account</h3>

                <p>
                    Register on the platform and create your
                    reader profile.
                </p>

            </div>


            <div class="step">

                <div class="step-top">
                    <span>02</span>
                </div>

                <h3>List Your Book</h3>

                <p>
                    Add the books you want to exchange with
                    their details and condition.
                </p>

            </div>


            <div class="step">

                <div class="step-top">
                    <span>03</span>
                </div>

                <h3>Find a Book</h3>

                <p>
                    Search for books by title, author,
                    category or location.
                </p>

            </div>


            <div class="step">

                <div class="step-top">
                    <span>04</span>
                </div>

                <h3>Send a Request</h3>

                <p>
                    Send an exchange request to the
                    book owner.
                </p>

            </div>


            <div class="step">

                <div class="step-top">
                    <span>05</span>
                </div>

                <h3>Complete the Exchange</h3>

                <p>
                    Communicate with the reader and
                    complete your book exchange.
                </p>

            </div>

        </div>

    </section>


    <!-- ================= CATEGORIES ================= -->

    <section class="categories" id="categories">

        <div class="section-heading center">

            <p>EXPLORE BOOKS</p>

            <h2>
                Something for Every Reader
            </h2>

        </div>


        <div class="category-grid">

            <div class="category-card">
                <div class="category-icon">N</div>
                <h3>Novels</h3>
                <p>Stories, fiction and unforgettable characters.</p>
            </div>

            <div class="category-card">
                <div class="category-icon">B</div>
                <h3>Biography</h3>
                <p>Real stories from inspiring lives.</p>
            </div>

            <div class="category-card">
                <div class="category-icon">S</div>
                <h3>Self Help</h3>
                <p>Books for learning and personal growth.</p>
            </div>

            <div class="category-card">
                <div class="category-icon">C</div>
                <h3>Comics</h3>
                <p>Creative stories filled with imagination.</p>
            </div>

            <div class="category-card">
                <div class="category-icon">K</div>
                <h3>Children</h3>
                <p>Fun and imaginative books for young readers.</p>
            </div>

            <div class="category-card">
                <div class="category-icon">T</div>
                <h3>Travel</h3>
                <p>Explore places through books and stories.</p>
            </div>

        </div>

    </section>


    <!-- ================= CTA ================= -->

    <section class="cta">

        <div class="cta-content">

            <p>START YOUR READING JOURNEY</p>

            <h2>
                Your Next Favorite Book<br>
                Might Be Waiting for You.
            </h2>

            <span>
                Join readers, exchange books and keep stories moving.
            </span>

            <br><br>

            <a href="auth/register.php" class="cta-btn">
                Create Your Account
            </a>

        </div>

    </section>


    <!-- ================= FOOTER ================= -->

    <footer>

        <div class="footer-top">

            <div class="footer-brand">

                <div class="logo">
                    Book<span>Exchange</span>
                </div>

                <p>
                    Exchange books. Share stories.
                    Build a reading community.
                </p>

            </div>


            <!-- <div class="footer-links">

                <a href="#about">About</a>
                <a href="#how-it-works">How It Works</a>
                <a href="#categories">Categories</a>
                <a href="auth/login.php">Login</a>
                <a href="auth/register.php">Register</a>

            </div> -->

        </div>


        <!-- <div class="footer-bottom">

            <p>
                &copy; <?php echo date("Y"); ?>
                Book Exchange System. All rights reserved.
            </p>

        </div> -->

    </footer>

</body>
</html>
