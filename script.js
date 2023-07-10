document.addEventListener('DOMContentLoaded', function() {
    var lastClickedButton = localStorage.getItem('lastClickedButton');
  
    var contentSections = document.querySelectorAll('.content-section');
    contentSections.forEach(function(section) {
      section.style.display = 'none';
    });
  
    var navbarLinks = document.querySelectorAll('.navbar-nav .nav-link');
    navbarLinks.forEach(function(link) {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        var targetSectionId = this.getAttribute('href');
  
  
        navbarLinks.forEach(function(link) {
          link.classList.remove('active');
        });
  
        contentSections.forEach(function(section) {
          section.style.display = 'none';
        });
  
        var targetSection = document.querySelector(targetSectionId);
        if (targetSection) {
          targetSection.style.display = 'block';
          link.classList.add('active'); 
  
          localStorage.setItem('lastClickedButton', link.getAttribute('href'));
        }
      });
  
      if (link.getAttribute('href') === lastClickedButton) {
        link.classList.add('active');
        var targetSection = document.querySelector(link.getAttribute('href'));
        if (targetSection) {
          targetSection.style.display = 'block';
        }
      }
    });
  });

  document.addEventListener('DOMContentLoaded', function() {
    loadMessages();
  
    document.getElementById('messageForm').addEventListener('submit', function(event) {
      event.preventDefault();
      var messageInput = document.getElementById('messageInput');
      var message = messageInput.value.trim();
      var receiver_id = document.querySelector('[name="receiver_id"]').value;
  
      messageInput.value = '';
  
      if (message !== '') {
        fetch('send_message.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: 'receiver_id=' + receiver_id + '&message=' + encodeURIComponent(message)
        })
        .then(function(response) {
          if (response.ok) {
            loadMessages();
          }
        })
        .catch(function(error) {
          console.log('Error sending message:', error);
        });
      }
    });
    function loadMessages() {
      var receiver_id = document.querySelector('[name="receiver_id"]').value;
      fetch('get_messages.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'receiver_id=' + receiver_id
      })
      .then(function(response) {
        if (response.ok) {
          return response.text();
        } else {
          throw new Error('Error fetching messages');
        }
      })
      .then(function(responseText) {
        var tempContainer = document.createElement('div');
        tempContainer.innerHTML = responseText;
  
        var messagesContainer = document.getElementById('messagesContainer');
  
        messagesContainer.innerHTML = '';
  
        tempContainer.childNodes.forEach(function(node) {
          messagesContainer.appendChild(node.cloneNode(true));
        });
  
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
      })
      .catch(function(error) {
        console.log('Error loading messages:', error);
      });
    }
    setInterval(loadMessages, 500);
  });
  document.addEventListener('DOMContentLoaded', function() {
    // Add task input dynamically
    document.getElementById('addTaskBtn').addEventListener('click', function() {
      var taskContainer = document.querySelector('.task-container');
      var newTask = taskContainer.querySelector('.tasks').cloneNode(true);
  
      // Clear the input values
      var inputs = newTask.querySelectorAll('input, textarea');
      inputs.forEach(function(input) {
        input.value = '';
      });
  
      // Append the new task input to the container
      taskContainer.appendChild(newTask);
    });
  });
  var myDiv = document.getElementsByClassName('isEmpty');
  if (myDiv.innerHTML.trim() === '') {
    myDiv.style.display = 'none';
  } else {
    myDiv.style.display = 'block';
  }