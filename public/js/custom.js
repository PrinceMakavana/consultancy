
var form_common_functions = {
    resetErrors: function (form_id, errs) {
        $(`#${form_id} .invalid-feedback`).html('');
        $(`#${form_id} .form-control`).removeClass('is-invalid');
        for (index in errs) {
            $(`#${form_id} .form-control#${index}`).addClass('is-invalid');
            $(`#${form_id} .invalid-feedback.err-${index}`).html(errs[index][0]);
        }
    },
    setInputSelectOpts: function (selector, options) {
        $(selector).html('');
        $(selector).append('<option value="">Select</option>');
        if (options && options.length) {
            options.forEach(e => {
                $(selector).append(`<option value="${e.id}">${e.name}</option>`);
            })
        }
    }
}

var load_form_data = {
    select_tag: function (form_id, select_tag_id, api_name) {
        $.ajax({
            url: apis[api_name],
            success: (data) => {
                if (data && data.status) {
                    form_common_functions.setInputSelectOpts($(`#${form_id} #${select_tag_id}`), data.meta)
                } else {
                    form_common_functions.setInputSelectOpts($(`#${form_id} #${select_tag_id}`), [])
                }
            }, error: (err) => {

            }
        })
    },
}

function submitAddSipForm(form, event, success_url) {
    event.preventDefault();
    data = $(form).serializeArray();
    let years = $('input[name=investment_for_year]').val();
    let months = $('input[name=investment_for_month]').val();

    data.push({
        name: 'investment_for', value: `${years} years,${months} months`
    })

    $.ajax({
        method: 'POST',
        data: data,
        url: apis.sip_add,
        success: (data) => {
            if (data && !data.status) {
                form_common_functions.resetErrors(form.id, data.data)
            } else {
                form_common_functions.resetErrors(form.id, {});
                alert(data.data);
                window.location.href = success_url;
            }
        }, error: (err) => {
            if (err.status == 422) {
                form_common_functions.resetErrors(form.id, err.responseJSON.meta.errors)
            }
        }
    })
}


var app = angular.module('app', []);
app.controller('mainCtrl', function ($scope, $http) {

    $scope.assuredPayouts = []

    $scope.addPayout = () => {
        $scope.assuredPayouts.push({});
    }
    $scope.removePayout = (index) => {
        $scope.assuredPayouts.splice(index, 1);
    }
});

app.component('formElement', {
    bindings: {
        conf: '=',
        remove: '='
    },
    templateUrl: `${config.viewFolder}/form-elements.html`,
    controller: function ($scope) {
        this.$onInit = function () {
            if ($scope.$ctrl.remove && $scope.$ctrl.remove.length) {
                $scope.$ctrl.remove.forEach(e => delete $scope.$ctrl.conf[e])
            }
        };
    }
})