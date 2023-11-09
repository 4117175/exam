const lightBulb = document.getElementById("lightBulb");

lightBulb.addEventListener("click", () => {
    lightBulb.classList.toggle("light-on");
    lightBulb.classList.toggle("light-off");
});