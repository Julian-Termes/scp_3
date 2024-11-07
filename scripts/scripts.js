async function loadSCPData() {
  const params = new URLSearchParams(window.location.search);
  const scpNumber = params.get("scp");

  if (!scpNumber) {
    document.getElementById("subject").textContent = "SCP not found";
    return;
  }

  try {
    const response = await fetch("scp-data.json");
    const data = await response.json();

    const scp = data[`scp-${scpNumber}`];

    if (!scp) {
      document.getElementById("subject").textContent = "SCP not found";
      return;
    }

    // Update the HTML with the SCP data
    document.getElementById("subject").textContent = `Item #: ${scp.subject}`;
    document.getElementById("class").textContent = `Object Class: ${scp.class}`;
    document.getElementById("description").textContent = scp.description;
    document.getElementById("containment").textContent = scp.containment;
    document.getElementById("discovery").textContent = scp.discovery;

    const scpImage = document.getElementById("scp-image");
    scpImage.src = `images/scp-${scpNumber}.webp`;
    scpImage.onerror = function () {
      this.src = `images/scp-${scpNumber}.jpg`;
    }; // Error catching for testing
  } catch (error) {
    console.error("Error loading SCP data:", error);
    document.getElementById("subject").textContent = "Error loading SCP data";
  }
}

// Function to read the SCP content aloud using speechsynthesis API
function readAloud() {
  const speechSynthesis = window.speechSynthesis;

  // Cancel any ongoing speech, just in case i want to add an additional button
  speechSynthesis.cancel();

  // Grab the text from the loaded SCP content
  const subject = document.getElementById("subject").textContent;
  const objectClass = document.getElementById("class").textContent;
  const description = document.getElementById("description").textContent;
  const containment = document.getElementById("containment").textContent;
  const discovery = document.getElementById("discovery").textContent;

  // Create an array of text content to be spoken sequentially
  const speechText = [
    `${subject}`,
    `${objectClass}`,
    `Description: ${description}`,
    `Containment: ${containment}`,
    `Discovery: ${discovery}`,
  ];

  // Function to speak each part of the text sequentially
  function speakPart(index) {
    if (index >= speechText.length) {
      return; // Exit if no more parts to speak
    }

    const utterance = new SpeechSynthesisUtterance(speechText[index]);
    utterance.rate = 1; // Normal rate
    utterance.pitch = 1; // Normal pitch
    utterance.lang = "en-US"; // Set language to English (US)

    // Once the current utterance is done, speak the next part
    utterance.onend = function () {
      speakPart(index + 1);
    };

    // Speak the current utterance
    speechSynthesis.speak(utterance);
  }

  // Start speaking the first part
  speakPart(0);
}

// Stop Function
function stopReading() {
  const speechSynthesis = window.speechSynthesis;
  speechSynthesis.cancel(); // Stop the ongoing speech immediately
}

// Load SCP data when the page is ready
window.onload = loadSCPData;

// Attach event listeners to the buttons
document.getElementById("read-aloud-btn").addEventListener("click", readAloud);
document.getElementById("stop-btn").addEventListener("click", stopReading);
