(function ($) {
  $(document).ready(function () {
    $.ajax({
      url: 'http://localhost/steefWitjes1/dropdown-options',
      method: 'GET',
      dataType: 'json',
      success: function (data) {
        // console.log(data);
        // console.log("success1");

        // Clear dropdowns before populating
        clearDropdown('city');
        clearDropdown('postal_code');
        clearDropdown('street');
        clearDropdown('number');
        clearDropdown('addition');

        populateDropdown('city', data.city);
        populateDropdown('postal_code', data.postal_code);
        populateDropdown('street', data.street);
        populateDropdown('number', data.number);
        populateDropdown('addition', data.addition);
      },
      error: function (xhr, status, error) {
        console.error('Error fetching dropdown options:', error);
      }
    });


		function populateDropdown(id, values) {
  var dropdown = $('#' + id);
  dropdown.empty();
  dropdown.append($('<option>').text('--Select ' + id.charAt(0).toUpperCase() + id.slice(1) + '--')); // Placeholder option

  if (values && Array.isArray(values) && values.length > 0) {
    $.each(values, function (index, value) {
      dropdown.append($('<option>').text(value).val(value));
    });
  } else {
    console.error('Invalid data for ' + id);
  }
}



    function clearDropdown(id) {
      $('#' + id).empty();
    }
    
     function fetchOptionsByCity(city) {
      $.ajax({
        url: 'http://localhost/steefWitjes1/dropdown-options-by-city-name/' + city,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          // console.log(data);
          // console.log("success2");

          // Clear dropdowns before populating
          clearDropdown('postal_code');
          clearDropdown('street');
          clearDropdown('number');
          clearDropdown('addition');

          // Populate dropdowns with fetched options
          populateDropdown('postal_code', data.postal_codes); // Assuming index 1 is postal code
           populateDropdown('street', data.streets);
        populateDropdown('number', data.numbers);
        populateDropdown('addition', data.additions);
        },
        error: function (xhr, status, error) {
          console.error('Error fetching dropdown options:', error);
        }
      });
    }
	function fetchOptionsByPostal(postalcode) {
      $.ajax({
        url: 'http://localhost/steefWitjes1/dropdown-options-by-postal-code/' + postalcode,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          // console.log(data);
          // console.log("success3");

          // Clear dropdowns before populating
          //clearDropdown('city');
          clearDropdown('street');
          clearDropdown('number');
          clearDropdown('addition');

          // Populate dropdowns with fetched options
		  var selectedCity = $('#city').find(":selected").val();
		  if(!selectedCity){
		  populateDropdown('city', data.cities); // Assuming index 1 is postal code
		  }
           populateDropdown('street', data.streets);
        populateDropdown('number', data.numbers);
        populateDropdown('addition', data.additions);
        },
        error: function (xhr, status, error) {
          console.error('Error fetching dropdown options:', error);
        }
      });
    }
    
     // Function to fetch options based on postal code and city
  function fetchOptionsByCityAndPostal(selectedCity,postal_code) {
  $.ajax({
        url: 'http://localhost/steefWitjes1/unique-values/' + selectedCity + '/' + postal_code,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
          console.log(data);
          console.log("success3");

          // Clear dropdowns before populating
          //clearDropdown('city');
          clearDropdown('street');
          clearDropdown('number');
          clearDropdown('addition');

          // Populate dropdowns with fetched options
          //populateDropdown('city', data.cities); // Assuming index 1 is postal code
           populateDropdown('street', data.streets);
        populateDropdown('number', data.numbers);
        populateDropdown('addition', data.additions);
        },
        error: function (xhr, status, error) {
          console.error('Error fetching dropdown options:', error);
        }
      });
  }

  // Event listener for onchange event of postal code input
$('#postal_code').change(function () {
    var postal_code = $(this).val();
	if (postal_code) {
        fetchOptionsByPostal(postal_code);
      }
  
});

    
    // Event listener for city select change
    $('#city').change(function () {
      var selectedCity = $(this).val();
      if (selectedCity) {
        fetchOptionsByCity(selectedCity);
      }
    });
  });
})(jQuery);