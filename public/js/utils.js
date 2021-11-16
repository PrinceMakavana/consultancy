/**
 * day = 
 * today
 * tomorrow
 * yesterday
 * dayaftertomorrow
 * daybeforeyesterday
 */
function getDate(day = 'today') {
    let a = new Date();
    switch (day) {
        case 'tomorrow':
            a.setDate(a.getDate() + 1)
            break;
        case 'yesterday':
            a.setDate(a.getDate() - 1)
            break;
        case 'dayaftertomorrow':
            a.setDate(a.getDate() + 2)
            break;
        case 'daybeforeyesterday':
            a.setDate(a.getDate() - 1)
            break;
        default:
            break;
    }
    return a;
}

function MakeQuerablePromise(promise) {
    // Don't modify any promise that has been already modified.
    if (promise.isResolved) return promise;

    // Set initial state
    var isPending = true;
    var isRejected = false;
    var isFulfilled = false;

    // Observe the promise, saving the fulfillment in a closure scope.
    var result = promise.then(
        function (v) {
            isFulfilled = true;
            isPending = false;
            return v;
        },
        function (e) {
            isRejected = true;
            isPending = false;
            throw e;
        }
    );

    result.fulfilled = function () { return isFulfilled; };
    result.pending = function () { return isPending; };
    result.reject = function () { return isRejected; };
    return result;
}

class cField {
    value = '';
    errors = [];
    type = 'text';
    label = '';
    placeholder = '';
    options = [];
    onchange = '';
    constructor(opt = {}) {
        if (opt) {
            if (opt.value) this.value = opt.value
            if (opt.errors) this.errors = opt.errors
            if (opt.type) this.type = opt.type
            if (opt.label) this.label = opt.label
            if (opt.placeholder) this.placeholder = opt.placeholder
            if (opt.options) this.options = opt.options
            if (opt.onchange) this.onchange = opt.onchange
        }
    }
}

class Other {
    static titles(title = false) {
        let titles = {
            'dashboard': 'Dashboard',
            'action': 'Action',
            'no_data': 'No Data found.',
            'confirm_msg': 'Are you sure?',
            'logout_success': 'Logout successfully.',
        };
        if (title) {
            return titles[title];
        } else {
            return titles;
        }
    }
}

/**
 * Model
 * Role
 */
class InsuranceField {

    static titles(title = false) {
        let titles = {
            'role': 'Role',
            'create': 'Role Create',
            'not_found': 'Role not found.'
        };
        if (title) {
            return titles[title];
        } else {
            return titles;
        }
    }

    static attributes(attribute = false) {
        let attributes = {
            'fieldname': 'Name',
            'description': 'Description',
            'type': 'Type',
            'options': 'Options',
            'is_required': 'Is Required',
            'status': 'Status',
        };
        if (attribute) {
            return attributes[attribute];
        } else {
            return attributes;
        }
    }

}