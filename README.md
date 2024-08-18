# Optimizing Demand Generation

Welcome to our cutting-edge Demand Generation system that leverages events to captivate participants' interests and deliver tailor-made experiences! 🌐✨

## Overview:
This repository houses the core components of our innovative demand generation system. Through meticulously crafted events, we captivate participants' attention and seamlessly guide them through a personalized journey. This journey culminates in the recommendation of sessions and products that align with their specific interests.

## Key Features:
1. **Event-Driven Engagement:**
   - Craft engaging events that pique participants' interests.
   - Dynamically adapt event content based on real-time participant interactions.

2. **Journey Mapping:**
   - Create personalized journey maps for each participant.
   - Utilize advanced algorithms to recommend sessions tailored to individual preferences.

3. **Automated Email System:**
   - Send personalized journey maps directly to participants via email.
   - Deliver timely and relevant information about recommended sessions.

4. **Feedback Collection:**
   - Collect feedback from participants post-event.
   - Analyze feedback to understand participant satisfaction and preferences.

5. **Product Recommendations:**
   - Based on event attendance and feedback, recommend relevant products via email.
   - Enhance post-event engagement by providing personalized product suggestions.

## Usage Workflow:

1. **Pre-event Setup:**
   - Upload event dataset and participant list to the system.
   - The system will automatically send invitation emails to every user, prompting them to participate in an interest survey tailored to the upcoming event.

2. **Interest Survey & Journey Map Generation:**
   - Participants respond to the interest survey, shaping their preferences.
   - The system utilizes survey responses to dynamically generate personalized journey maps, recommending sessions aligned with participants' interests.
   - Participants receive a comprehensive journey map with QR codes for their selected sessions, facilitating easy event check-in.

3. **Pre-event Journey Map Distribution:**
   - Participants receive their personalized journey maps containing QR codes via email.
   - The provided QR codes can be printed and scanned during the event for streamlined session attendance tracking.

4. **Event Proper:**
   - Scan participants' QR codes for each session they attend to efficiently track their event engagement.
   - Real-time attendance tracking ensures accurate insights into participant interactions.

5. **Post-event Custom Survey:**
   - Following the event, the system automatically sends a custom post-event survey to participants based on the sessions they attended.
   - Gather valuable feedback on each session to further refine future events.

6. **Product Recommendations:**
   - Based on the initial interest survey, sessions attended, and post-event survey feedback, the system intelligently generates personalized product recommendations.
   - Participants receive tailored product suggestions via email, enhancing their post-event engagement and fostering continued interest.

## Get Started:
Clone this repository and follow the comprehensive documentation to seamlessly integrate EventForge into your event management strategy. Elevate your events by providing personalized experiences from pre-event anticipation to post-event satisfaction.


### Event Recommender Installation Guide
### Clone the Repository

1. Open your terminal or Git Bash.

2. Run the following command to clone the repository:

    ```bash
    git clone https://github.com/laysonaljon/event-recommender.git
    ```

### Move the Repository to `C:\xampp\htdocs`

1. Assuming you are using a command prompt on Windows, execute the following commands:

    ```bash
    mv event-recommender C:\xampp\htdocs
    cd C:\xampp\htdocs\event-recommender
    ```

   Now, you've moved the repository to `C:\xampp\htdocs`.

### Configure XAMPP
1. Open XAMPP Control Panel and start Apache.

2. Go to Apache config.

3. Select "php.ini".

4. Find the line ";extension=gd".

5. Remove the semicolon at the beginning to enable GD: "extension=gd".

6. Save changes and close.

7. Restart Apache.

![415500071_677326124306965_1997418624583692692_n](https://github.com/laysonaljon/event-recommender/assets/80148930/af8fc6ec-70eb-4f85-bd77-0b793d9f82e1)

![419995843_1522626908577502_1778546615210340762_n](https://github.com/laysonaljon/event-recommender/assets/80148930/4290cf22-88f6-49c6-9667-7c0b12442846)


### Set Up the Database

1. Open phpMyAdmin by visiting [http://localhost/phpmyadmin](http://localhost/phpmyadmin) in your web browser.

2. Create a new database named `new_event`.

3. In phpMyAdmin, navigate to the newly created database `new_event`.

4. Click on the "Import" tab.

5. Choose the file `new_event.sql` from the `database` directory in your cloned repository.

6. Click on the "Go" button to import the database structure and data.

   Now, your database is set up and populated with the necessary data.


### Install NumPy, and scikit-learn

1. **Check if Python and pip are installed:**

    - Open your terminal or command prompt.
    - Run the following command to check if Python is installed:

        ```bash
        python --version
        ```

      If Python is not installed, download and install it from [Python's official website](https://www.python.org/downloads/).

    - Run the following command to check if pip is installed:

        ```bash
        pip --version
        ```

      If pip is not installed, you can install it by following the instructions [here](https://pip.pypa.io/en/stable/installation/).

2. **Install NumPy:**

    - Run the following command to install NumPy:

        ```bash
        pip install numpy
        ```

3. **Install scikit-learn:**

    - Run the following command to install scikit-learn:

        ```bash
        pip install scikit-learn
        ```


### Final Notes

- Ensure that your XAMPP server is running. Start it by opening the XAMPP Control Panel and clicking on the "Start" button for Apache and MySQL.

- Access your application by visiting [http://localhost](http://localhost) in your web browser.

Note: The exact steps may vary depending on your system configuration. 

**Experience the Future of Event Engagement with our Project!** 🌐🚀
