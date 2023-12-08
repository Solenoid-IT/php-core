# Project
<b>Core</b> is a smart HTTP/CLI <b>MVC framework</b> for building easy or very complex endpoints with a large set of integrated backend libraries.
<br><br>
The current project contains a sample web app to make developers easier to learn the internal logic of this framework.
<br><br>
For the official and complete documentation you should navigate to [Knowledge Base](https://kb.solenoid.it).
<br><br>
<p align="center">
  <img alt="Solenoid Core Logo" src="https://cdn.solenoid.it/logo/core.png">
</p>
<br>
<br>

# Setup
To create a new Core project you just have to run the following commands from your terminal :
<br><br>
`git clone https://github.com/Solenoid-IT/php-core ./core`
<br>
`cd ./core/private`
<br>
`php x init`

# Requirements
OS                  >= Ubuntu <b>22.04.1 LTS</b>
<br>
WebServer           >= Apache <b>2.4</b>
<br>
Runtime-Environment >= PHP <b>7.3</b>

# Contexts
Core can run both <b>HTTP</b> and <b>CLI</b> contexts with the same codebase :
<br><br>
    <b>HTTP</b> = path resolver -> gate -> middleware groups -> controller -> response
    <br>
    <b>CLI</b>  = task runner -> response
    <br>
<br>
<b>Store</b>, <b>model</b> and <b>service</b> objects are shared between HTTP and CLI so they are defined once and are usable on both contexts.
<br>
<br>

# Logs
Core will capture and log both all of the thrown errors and every execution call
<br>
<br>

# Environments
Core give you the ability to run under different specialized environment types ("<b>dev</b>" and "<b>prod</b>" are the reserved ones but you can define your custom ones) :
<br><br>
    <b>dev</b>    = This type will show you every error in the system and use uncached version of the web assets (css, js or other static resources) when you define the asset url with the function Core::asset
    <br><br>
    <b>prod</b>   = This type will hide every error from the system (security issues) and use cached version of the web assets to improve the frontend performance and ux
    <br><br>
    <b>custom</b> = This type can be defined in a custom way
<br>
<br>
( Error logs will be tracked independently from the current environment settings )
<br>
<br>

# Utility
Core has an integrated top-level CLI utility "<b>x</b>" to make some useful operations like to initialize the project, install packages, manage git repos, creating objects (stores, models, services, middlewares or controllers), manage apache, certs and crons.
<br>
<br>

# Routes
Core has a map-file to define how to resolve a request by its URL path.
<br><br>
    <b>Route</b>       -> Goes to a destination object (you can attach multiple middleware groups or tags to it)
    <br>
    <b>Path</b>        -> Can be static or dynamic (containing placeholder-variables)
    <br>
    <b>Verb</b>        -> HTTP verb of the path (ex. GET, RPC, SSE or DELETE)
    <br>
    <b>Destination</b> -> Object that will run the stack ( gate -> middleware groups -> controller )
<br>
<br>

# Integrations
Core has a built-in support for <b>SvelteKit</b> as frontend JS framework.
<br>
You can install it by executing : `php x svelte install`
<br>
<br>

# UI
This project uses the [sb-admin](https://github.com/StartBootstrap/startbootstrap-sb-admin/tree/master) as UI template
<br>
<br>

# Performance
Memory used for bootstrapping (minimal consumption) :
<br><br>
<b>HTTP</b>     -> 216 B
<br>
<b>CLI</b>      -> 96 B
<br>
<br>

# License
Solenoid <b>Core</b> framework is subjected to MIT license so it is opensource friendly