function selectCustomer(id) {
    return fetch('/manager/customer/api/' + id)
        .then(response => response.json())
        .then(data => { return data })
        .catch(error => {
            alert('Lỗi lấy chi tiết !' + error);
            // console.error('Lỗi khi tải dữ liệu từ API:', error);

        })
}

async function fetchCustomer(){
    return await fetch('/manager/customer/api')
        .then(response => response.json())
        .then(data => {
            return data.data;
        })
        .catch(error => {
            alert('Lỗi lấy danh sách !');
            // console.error('Lỗi lấy danh sách !', error);
        });
}

const getCustomer = async (class_select) => {
    let data = await fetchCustomer();
    $(`.${class_select}`)
        .select2({
            data: data.map(country => {
                return {
                    id: country.id,
                    text: `${country.name}`
                };
            })
        })
        .val(null)
        // .trigger('change')
}
