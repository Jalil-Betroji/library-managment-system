const my_reservation_btn = document.getElementById("my_Reservation");
const setting_btn = document.getElementById("setting");

const reservation_List_Section = document.getElementById("reservation_List");
// const profile_homePage_section = document.getElementById("profile_homePage");
const Profile_section = document.getElementById("Profile");

my_reservation_btn.addEventListener("click", () => {
  reservation_List_Section.classList.remove("profile_hide");
  // profile_homePage_section.classList.add("profile_hide");
  Profile_section.classList.add("profile_hide");
});

setting_btn.addEventListener("click", () => {
  Profile_section.classList.remove("profile_hide");
  reservation_List_Section.classList.add("profile_hide");
  // profile_homePage_section.classList.add("profile_hide");
});