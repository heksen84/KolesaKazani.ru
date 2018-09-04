export default {
	max_load_images: 20,
    options_sdelka: 
    [
        { value: '0', text: 'Покупка' },
        { value: '1', text: 'Продажа' },
        { value: '2', text: 'Обмен' },
        { value: '3', text: 'Частичный обмен' },
        { value: '4', text: 'Отдам даром' },
        { value: '5', text: 'Сдача в аренду' }
    ],
    advert: 
    [{   
        deal_selected:null, 
        category:null, 
        text:"",
        price:0,
        images:[],
        location:[],
        chars:[] 
    }]              // здесь хар-ки: тип объявления, категория, 
                    // хар-ки транспорта в виде json'a
                    // vuex не прокатывает т.к. сайт не одностраничный (гибридный)
}