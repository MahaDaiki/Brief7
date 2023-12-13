let formsDiv = document.querySelector('#forms');
let addBtn = document.querySelector('#btn_add');
let removeBtn = document.querySelector('#btn_remove');
let i = document.querySelector('#i');
i.value = 1;

addBtn.addEventListener('click', ()=>{
    formsDiv.innerHTML += `
    <div class="my-3">
        <input type="text" placeholder="First Name" class="input-field" required name="firstname-${i.value}">
        <input type="text" placeholder="Last Name" class="input-field" required name="lastname-${i.value}">
        <input type="text" placeholder="Username" class="input-field" required name="username-${i.value}">
        <input type="email" placeholder="Email" class="input-field" required name="email-${i.value}">
        <input type="password" placeholder="Password" class="input-field" required name="password-${i.value}">
        <input type="file" class="input-field" accept="image/*" required name="avatar-${i.value}">
        <select name="is_admin-${i.value}" class="input-field">
            <option value="admin">Admin</option>
            <option value="announcer">Announcer</option>
        </select>
    </div> `;
    i.value++;

});

removeBtn.addEventListener('click', ()=>{
    formsDiv.removeChild(formsDiv.children[i.value - 2]);
    i.value--;

});