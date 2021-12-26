## Introduction
This is a tool to sync movie subtitles in `SRT` format.
I wrote this in year 2014 for myself who was very addicted to watching movies, but not very good at comprehending English dialogs.
I was also just starting to learn and develop small projects using `PHP` and `JavaScript` during that time,
so this project was a perfect way to get my hands dirty!

Please forgive my younger self for any dirty and unsecured code.

<br>

## Installation
Just clone or download this repository on your preferred `PHP` server.

If you're using `XAMPP`, just move this project to your `htdocs` folder and you're good to go!

Sample path: `C:\xampp\htdocs\subedit`.

<br>

## Usage
Start your web server and use your favorite web browser and access `index.php` of this repository.

If you're using `XAMPP`, just start its `Apache` service and access this project in your `localhost`.

Sample URL: `http://localhost/subedit`.

To sync movie subtitles:
<ol>
    <li>Browse and upload your <code>.srt</code> file.</li>
    <li>Toggle <b>Delay</b> or <b>Forward</b> its timing by milliseconds, seconds, or minutes by entering values in the respective fields.</li>
    <li>
        Confirm your tweaks and copy the result script to a new or the previous <code>.srt</code> file.
        <small>
            <br>This is project I made for myself, so I don't bother copying and pasting the resulting script.
            PRs are welcome to automate this step.
        </small>
    </li>
</ol>