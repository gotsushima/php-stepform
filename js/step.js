// 共通のdisplayStep関数
function displayStep(stepNumber) {
  const steps = document.querySelectorAll(".list-step");
  steps.forEach((step, index) => {
    step.style.display = index + 1 === stepNumber ? "block" : "none";
  });
}

//step1
function initStep1() {
  document
    .querySelectorAll('#step1 input[type="radio"][name="entry_qualifications"]')
    .forEach((qualification) => {
      qualification.addEventListener("change", () => displayStep(2));
    });
}

//step2

function initStep2() {
  document
    .querySelectorAll('#step2 input[type="radio"][name="entry_work_styles"]')
    .forEach((element) => {
      element.addEventListener("change", () => displayStep(3));
    });

  document
    .querySelector("#back2")
    .addEventListener("click", () => displayStep(1));
}

//step3

function initStep3() {
  document
    .querySelectorAll('#step3 input[type="radio"][name="request_date_id"]')
    .forEach((element) => {
      element.addEventListener("change", () => displayStep(4));
    });

  document
    .querySelector("#back3")
    .addEventListener("click", () => displayStep(2));
}

//step4

function initStep4() {
  const selections = {
    prefecture: 0,
    city: 0,
    birthyear: 0,
  };

  const selectElements = {
    prefecture: document.querySelector('select[name="prefecture"]'),
    city: document.querySelector('select[name="city"]'),
    birthyear: document.querySelector('select[name="birthyear"]'),
  };

  const originalCityOptions = selectElements.city.innerHTML;

  const updateCityOptions = (prefecture) => {
    selectElements.city.innerHTML = prefecture
      ? '<option value="">選択してください</option>'
      : originalCityOptions;
    if (prefecture) {
      address[prefecture].forEach((item) => {
        const option = new Option(item, item);
        selectElements.city.add(option);
      });
    }
  };

  const checkSelections = () => {
    const allSelected = Object.values(selections).every((value) => value > 0);
    displayStep(allSelected ? 5 : 4);
  };

  const handleSelectionChange = (key) => (event) => {
    selections[key] = event.target.selectedOptions.length;
    if (key === "prefecture") {
      selections.city = 0;
      updateCityOptions(event.target.value);
    }
    checkSelections();
  };

  Object.keys(selectElements).forEach((key) => {
    selectElements[key].addEventListener("change", handleSelectionChange(key));
  });

  document
    .querySelector("#back4")
    .addEventListener("click", () => displayStep(3));
}

//step5

function initStep5() {
  const form = document.querySelector('form[name="contact_form"]');
  const submitBtn = document.getElementById("next5");
  const nameInput = form.querySelector('input[name="name"]');
  const telInput = form.querySelector('input[name="tel"]');
  const emailInput = form.querySelector('input[name="e-mail"]');

  let isNameTouched = false;
  let isTelTouched = false;
  let isEmailTouched = false;

  // 初期状態で送信ボタンを無効化
  submitBtn.disabled = true;

  // Function to show error message within an existing <p class="error">
  function showError(inputElement, message) {
    // Locate the <p class="error"> element related to the input
    const errorElement = inputElement
      .closest(".form-item")
      .querySelector(".error");
    if (errorElement) {
      errorElement.textContent = message;
      errorElement.style.display = "block"; // Make sure it's visible
    }
  }

  // Function to hide error message
  function hideError(inputElement) {
    const errorElement = inputElement
      .closest(".form-item")
      .querySelector(".error");
    if (errorElement) {
      errorElement.textContent = ""; // Clear the error message
      errorElement.style.display = "none"; // Hide the error element
    }
  }

  function checkRepeatedDigits(tel) {
    return /(\d)\1{7,}$/.test(tel.slice(-8));
  }

  function validateInput(inputElement, isValid, errorMessage) {
    if (isValid) {
      hideError(inputElement);
    } else if (
      (inputElement === nameInput && isNameTouched) ||
      (inputElement === telInput && isTelTouched) ||
      (inputElement === emailInput && isEmailTouched)
    ) {
      showError(inputElement, errorMessage);
    }
  }

  function checkForm() {
    let isValidName = nameInput.value.trim() !== "";
    let isValidTel =
      telInput.value.match(/^\d{11}$/) && !checkRepeatedDigits(telInput.value);
    let isValidEmail =
      emailInput.value === "" ||
      emailInput.value.match(/^[^@\s]+@[^@\s]+\.[^@\s]+$/);

    validateInput(nameInput, isValidName, "お名前は必須項目です。");
    validateInput(telInput, isValidTel, "有効な電話番号を入力してください。");
    validateInput(
      emailInput,
      isValidEmail,
      "有効なメールアドレスを入力してください。"
    );

    submitBtn.disabled = !(isValidName && isValidTel);
  }

  // Inputイベントリスナーを追加
  nameInput.addEventListener("input", () => {
    isNameTouched = true;
    checkForm();
  });
  telInput.addEventListener("input", () => {
    isTelTouched = true;
    checkForm();
  });
  emailInput.addEventListener("input", () => {
    isEmailTouched = true;
    checkForm();
  });

  document
    .querySelector("#back5")
    .addEventListener("click", () => displayStep(4));
}

// DOMContentLoadedイベントで各ステップを初期化

document.addEventListener("DOMContentLoaded", function () {
  initStep1();
  initStep2();
  initStep3();
  initStep4();
  initStep5();
  displayStep(1);
});
