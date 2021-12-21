const timer = document.getElementById("timer");
const submitExam = document.querySelector(".examSubmitBtn");
// const addBtn = document.querySelector(".addStudentBtn");
// const modal1 = document.querySelector(".modal");
// const closemodal1 = document.querySelector(".close-modal-Btn");

// addBtn.addEventListener("click", function (e) {
//   e.preventDefault();
//   modal1.style.display = "block";
// });

// closemodal1.addEventListener("click", function (e) {
//   e.preventDefault();
//   modal1.style.display = "none";
// });

var c = 3600;
var t;
timedCount();

function timedCount() {
  var hours = parseInt(c / 3600) % 24;
  var minutes = parseInt(c / 60) % 60;
  var seconds = c % 60;

  var result =
    (hours < 10 ? "0" + hours : hours) +
    ":" +
    (minutes < 10 ? "0" + minutes : minutes) +
    ":" +
    (seconds < 10 ? "0" + seconds : seconds);

  timer.innerHTML = result;
  if (c == 0) {
    submitExam.click();
    console.log("Time out!");
  }
  c = c - 1;
  t = setTimeout(function () {
    timedCount();
  }, 1000);
}
