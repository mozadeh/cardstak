$(function() {

    $('#ms').magicSuggest({
        data: 'http://nicolasbize.com/magicsuggest/tutorial/3/get_countries.php',
        valueField: 'idCountry',
        displayField: 'countryName'
    });

});