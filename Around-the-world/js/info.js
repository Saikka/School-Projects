//arrays for parts of world and for folders with pictures
var parts = ['Europe', 'Asia', 'Africa'];
var folders = ['pictures/flags/', 'pictures/animals/', 'pictures/flowers/'];


//creates class for navgator options where is possilbe to choose part of world
var Navigator = React.createClass({
    
    render: function() {
        var items = parts.map(function(p, index) {
            return (
                <li key={index}>
                     <a href="#" onClick={this.props.getPart.bind(this, p)}>{p}</a>
                </li> 
            );
        }.bind(this));
        return (
            <div id="nav"><ul>{items}</ul></div>
        )
    }
});


//main class where everything is printed to screen
var Countries = React.createClass({
    
    getInitialState: function() {
        return {
            countries: [],  //massive of countries from json
            amount: 0, // amount of coutries in one part
            part: 'Europe', // shows which part of world is chosen
            ind: 0, // index of country which is shown at the moment
            loaded: false, // shows is json loaded or not
            weather: ['', '', '', '', ''], //keeps weather data for each city of chosen country
            showWeather: [false, false, false, false, false], //tells to show or not to show weather for city
            
        };
    },
    
	
	// makes function getCountry to happen after first render
    componentDidMount: function() {
        this.getCountry();
    },
    
	//gets value of chosen part and invites getCountry so it would load new part of world
    getPart: function(p) {
        this.setState({part: p, weather: ['', '', '', '', ''], showWeather: [false, false, false, false, false]}, function() {this.getCountry();});
    },
    
	//calls to json and loads countries of chosen part of the world
    getCountry: function() {
        var name = this.state.part;
        var me = this;
        $.ajax({
            url: 'json/countries.json',
            cache: false,
            dataType: 'json'
        }).done(function(data) { 
            if (name == 'Europe') {me.setState({countries: data.Europe, loaded:true, amount: data.Europe.length});}
            else if (name == 'Asia') {me.setState({countries: data.Asia, loaded:true});}
            else if (name == 'Africa') {me.setState({countries: data.Africa, loaded:true});}
            console.log(this.state.countries);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            me.setState({infoText: textStatus+":"+errorThrown});
        });
    },
    
	//function which increases index of countries
    indexValue: function() {
        const i = this.state.ind;
        if (i>this.state.amount-2) return 0; else return i+1;
    },
	
	//function which decreases index of countries
	indexValue2: function() {
        const i = this.state.ind;
        if (i==0) return this.state.amount-1; else return i-1;
    },
    
	//work of button next which calls to function indexvalue so index would rise and weather data would be return to default
    forward: function() {
    this.setState({ind: this.indexValue(), weather: ['', '', '', '', ''], showWeather: [false, false, false, false, false]});
    },
	
	//work of button previous which calls to function indexvalue2 so index would go down and weather data would be return to default
	backward: function() {
    this.setState({ind: this.indexValue2(), weather: ['', '', '', '', ''], showWeather: [false, false, false, false, false]});
    },
    
	//on click calls through ajax to php function
    getWeather: function(i, index, code) {
		//gets weather from php function
        if (this.state.showWeather[index] == false) {
            $.ajax({
			//sends name of city and country's code
            url: 'php/weather.php?q=' + i + ',' + code,
            cache: false,
            datatype: 'json',
            success: function(data) {
                this.state.weather[index] = data;
                this.state.showWeather[index] = true;
				//sets weather of city and sets that weather is shown
                this.setState({weather: this.state.weather, showWeather: this.state.showWeather});  
            }.bind(this),	  
            error: function(xhr, status, err) {
                console.log('boo_error', status, err.toString());  
            }
            });
        }
		//if weather is shown hides it
        else {
            this.state.weather[index] = '';
            this.state.showWeather[index] = false;
            this.setState({weather: this.state.weather, showWeather: this.state.showWeather});
        }
    },
        

    
    render: function() {
	//gets index of country which should be shown now
    const testInd = this.state.ind; 
	//goes through array of countries and searches for country with same index and returns only that country
    const indStates = this.state.countries.filter( function(c, index) { return c.index === testInd } );
    return (
       <div>
	    {/* prints buttons and navigator of world's parts*/}
        <div id="navigator">
           <div id="buttons">
                <button onClick={this.backward}>Previous</button>
                <button onClick={this.forward}>Next</button>
           </div>
           <Navigator getPart={this.getPart} />
        </div>
		
		
	    <div id="country">
			{
				indStates.map(function(country,index){
				
					//changing background picture to country's flag
					document.body.style.backgroundImage = "url(" + folders[0] + country.image + ")";
				   
					//getting array of cities from json
					var cities = country.cities.map(function (i,index) { 
						//makes rows of table with cities and picture with function on click which shows or hides weather
						return (
							<tr> 
								<td> {i} </td> 
								<td key= {index}> <img src='pictures/weather.png' onClick={this.getWeather.bind(this,i, index, country.code)} /></td> 
								<td> {this.state.weather[index]} </td> 
							</tr>
						); 
					}, this); // binds getWeather to picture
							  
					return (
					<div key={index} data-key={index}>
					   <h1>{country.name}</h1> {/* prints country's name */}
					   <img id="flag" src={folders[0] + country.image} /> {/* prints country's flag */}
					   {/* prints country's capital and array of cities */}
					   <table id="cities"><tr><td>Capital: <b>{country.capital}</b><br />Largest cities:</td></tr>  {cities} </table>
					   {/* prints country's animal and flower */}
					   <table id="info"> 
						   <tr><td>Animal:<br />{country.animal}</td><td>Flower:<br />{country.flower}</td></tr>
						   <tr><td><img className="images" src={folders[1] + country.image} /></td><td><img className="images" src={folders[2] + country.image} /></td></tr>
					   </table>
					</div> )
				},this)
			}
		</div> { /*end of div id="country" */}
      </div>  //end of main div
    ); // end of main return
    }
});


ReactDOM.render(
    <Countries />, 
    document.getElementById("root")
);
    