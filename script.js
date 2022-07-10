const url = window.location.href;
const selectNurse = document.getElementById('select-nurses');
const selectDepartment = document.getElementById('select-department');
const selectShift = document.getElementById('select-shift');
const listWards = document.getElementById('list-wards');
const listNurse = document.getElementById('list-nurse');
const listDuty = document.getElementById('list-duty');

const nameWard = document.getElementById('name-ward');
const addWard = document.getElementById('add-ward');

const formNurse = document.getElementById('new-nurse');

const formSet = document.getElementById('nurse-ward');

const send = async function(data, text = false) {
    return await fetch('/controller.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then((response) => { 
        return text ? response.text() : response.json()
    });
}

selectNurse.onchange = async function() {
    await send({'controller': 'nurse', 'id': selectNurse.value})
    .then(value => listWards.innerHTML = value)
}

selectDepartment.onchange = async function() {
    await send({'controller': 'dep', 'dep': selectDepartment.value}, true)
    .then(str => new window.DOMParser().parseFromString(str, "text/xml"))
    .then(data => listNurse.innerHTML = data['activeElement']['innerHTML']);
}

selectShift.onchange = async function() {
    await send({'controller': 'shift', 'shift': selectShift.value}, true)
    .then(value => listDuty.innerHTML = value)
}

addWard.onclick = async function() {
    if (!nameWard.value.trim()) return;
    await send({'controller': 'newWard', 'name': nameWard.value})
    .then(res => res ? updateWardsList(res) : alert('Палата не была добавлена!'))
}

function updateNursesLists(list) {
    let res = '<option value="" disabled selected>Не выбрано</option>';
    list.forEach(el => {
        res += `<option value="${el['id_nurse']}">${el['name']}</option>`;
    })
    selectNurse.innerHTML = res;
    formSet.nurses.innerHTML = res;
}

function updateWardsList(list) {
    let res = '<option value="" disabled selected>Не выбрано</option>';
    list.forEach(el => {
        res += `<option value="${el['id_ward']}">${el['name']}</option>`;
    })
    formSet.wards.innerHTML = res;
}

formNurse.add.onclick = async function(e) {
    e.preventDefault();
    if (!formNurse.name.value.trim() || 
        !formNurse.date.value || 
        !formNurse.department.value ||
        !formNurse.shift.value) return;
    await send({'controller': 'newNurse', 
                'name': formNurse.name.value, 
                'date': formNurse.date.value, 
                'department': formNurse.department.value,
                'shift': formNurse.shift.value})
    .then(res => res ? updateNursesLists(res) : alert('Медсестра не была добавлена!'));
}
formSet.set.onclick = async function(e) {
    e.preventDefault();
    if (!formSet.nurses.value || !formSet.wards.value) return;

    await send({'controller': 'set', 'idNurse': formSet.nurses.value, 'idWard': formSet.wards.value})
    .then(res => res ? alert('Успешно присвоено!') : alert('Ошибка!'));
}
