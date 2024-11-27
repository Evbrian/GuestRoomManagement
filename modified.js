document.getElementById("bookingForm").addEventListener("submit", function(event) {
    event.preventDefault();
  
    // Get form values
    const roomType = document.getElementById("roomType").value;
    const checkInDate = document.getElementById("checkInDate").value;
    const checkOutDate = document.getElementById("checkOutDate").value;
    const guestCount = document.getElementById("guestCount").value;
  
    // Calculate the price based on room type and number of nights
    const roomPrices = {
      single: 1000,
      double: 1500,
      suite: 2500,
    };
  
    const checkIn = new Date(checkInDate);
    const checkOut = new Date(checkOutDate);
    const timeDiff = checkOut - checkIn;
    const numberOfNights = timeDiff / (1000 * 3600 * 24);
    const totalPrice = roomPrices[roomType] * numberOfNights*guestCount;
  
    // Show the booking summary
    document.getElementById("summaryRoomType").textContent = `Room Type: ${capitalizeFirstLetter(roomType)}`;
    document.getElementById("summaryDates").textContent = `Check-in: ${checkInDate} | Check-out: ${checkOutDate}`;
    document.getElementById("summaryGuests").textContent = `Guests: ${guestCount}`;
    document.getElementById("totalPrice").textContent = `Total Price: ksh${totalPrice.toFixed(2)}`;
  
    document.getElementById("bookingSummary").classList.remove("hidden");
  
    // Send the booking data to the PHP script using AJAX
    const formData = new FormData();
    formData.append('roomType', roomType);
    formData.append('checkInDate', checkInDate);
    formData.append('checkOutDate', checkOutDate);
    formData.append('guestCount', guestCount);
    formData.append('totalPrice', totalPrice.toFixed(2));
  
    fetch('modified.php', {
      method: 'POST',
      body: formData,
    })
    .then(response => response.text())
    .then(data => {
      alert(data); // Display the response from PHP (success or error)
    })
    .catch(error => {
      console.error('Error:', error);
    });
  });
  
  function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
  