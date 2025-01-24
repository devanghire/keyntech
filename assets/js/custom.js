function clearInputs() {
   $("select").prop("selectedIndex", 0);
   $("input").val("");
   $(".error").remove();
}
$(".btncloseCategory").click(function () {
   clearInputs();
});

$(document).on('click', '.addNew', function () {
   $(".rowforClone:first").clone().appendTo(".appendClone");
   $(".appendClone .rowforClone:last").find("#addNew").text('-');
   $(".appendClone .rowforClone:last input").val("");
   $(".appendClone .rowforClone:last select").prop("selectedIndex", 0);
   $(".appendClone .rowforClone:last").find(".addNew").addClass('removeIt').removeClass('addNew');

});
$(document).on('click', '.caret', function() {
   var toggler = $(this);
   for (i = 0; i < toggler.length; i++) {
      toggler[i].addEventListener("click", function() {
         var nestedElement = this.parentElement.querySelector(".nested");
         if (nestedElement) {
            nestedElement.classList.toggle("active");
         }
         this.classList.toggle("caret-down");
      });
   }
});
$(document).on('click', '.removeIt', function() {
   $(this).closest('.rowforClone').remove();
});
$(document).on('focusout', '.category_name', function() {
   var categoryText = $(this).val();
   checkCategoryName(categoryText);
});
$(document).ready(function() {
   getAllCategory();
});