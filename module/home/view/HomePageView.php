[[Extend src="/global/src/view/MainView.php"/]]

[[Block:BlockPageBody]]
	<div class="jumbotron">
    <h2>SSENSE Test</h2>
    <p class="lead">Welcome to the SSENSE Test! Please complete the tasks enumerated below</p>
    <h3>Project context:</h3>
    <ul>
        <li>PHP</li>
        <li>Framework: Silex</li>
        <li>CSS Framework: Bootstrap</li>
        <li>MVC archtecture</li>
        <li>Using composer for dependencies</li>
        <li>PSR-2 Coding Style guide</li>
        <li>You have access to the command line</li>
        <li>Using the command line, you can access MySQL, but you're free to install and use any other database.</li>
        <li>There's a Redis server already installed, but then again, you're free to install and use any other caching systems</li>
        <li>The project is setup using GIT</li>
        <li>You must create a pull request containing all of your changes</li>
    </ul>
    
    <p>You’re free to use any method.</p>

    <h3>Command line</h3>
    <ul>
        <li>
            The root on of the project is in: /home/ubuntu/workspace/Hiring-Test
        </li>
        <li>
            You have full access to the serveur using <strong>sudo</strong>
        </li>
        <li>
            MySQL has no specific user. Use "mysql -u root" if you want to use it
        </li>
        <li>
            Redis is already installed
        </li>
        <li>
            *composer autoloading needs to be refreshed after the creation of any new class
        </li>
    </ul>
    
    <h2>Task #1</h2>
    <h4>As a Developer, I must create a new page to display all the Canadian products that we have in stock</h4>
    <br />
    <h5><u>Details:</u></h5>
    <p>
        You must create the DB schema based on the <a href="/DB-Schema.jpeg" target="_blank">Database diagram</a>. <br />
        You must create a new page to display thoses products and link it in the menu. <br />
        You must display only the products that have a <strong>price in CAD</strong> and that have <strong>stocks in the inventory</strong>. <br />
    </p>
    
    <br />
    <h2>Task #2</h2>
    <h4>As a Developer, I must create a new page to display the upcoming weather for Montreal, for the next 7 days</h4>
    <br />
    <h5><u>Details:</u></h5>
    <p>
        The team have subscribe to <a href="https://developer.forecast.io/">https://developer.forecast.io/</a> API for the weather information. <br />
        The API has a limited number of calls per day. You need to use a caching system so we don't call the API nor the Database every time we display the page <br />
        <h5>Forecats API Key: e60efe99b1bf9036ce9a154a5c1c10ee</h5>
    </p>
</div>       
[[/Block:BlockPageBody]]