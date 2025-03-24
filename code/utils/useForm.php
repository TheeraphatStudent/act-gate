<?php

function saveFormScript()
{
    return '
    function saveForm(type) {
        let form = document.getElementById("form-content");
        let formData = new FormData(form);
        let data = {};

        formData.forEach((value, key) => {
            if (key === "cover" || key === "more-pic" || key === "description") return;
            data[key] = value;
        });

        localStorage.setItem(type + "_formData", JSON.stringify(data));
    }
    ';
}

function loadFormScript()
{
    return '
    function loadForm(type) {
        let savedData = localStorage.getItem(type + "_formData");
        if (savedData) {
            let form = document.getElementById("form-content");
            let data = JSON.parse(savedData);

            for (let key in data) {
             if (key === "cover" || key === "more-pic" || key === "description") continue;

                let element = form.querySelector("[name=\'" + key + "\']");
                if (element) {
                    element.value = data[key];
                }
            }
        }
    }
    ';
}

function clearFormScript()
{
    return '
    function clearForm(type) {
        localStorage.removeItem(type + "_formData");
    }
    ';
}
