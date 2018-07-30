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
    [
        {   
            type:       null, 
            category:   null, 
            desc:       null,
            price:      null,
            photos:     [],
            location:   [],
            transport:  
            {  
                year_release: null,
                rule_pos: null,
                probeg: null,
                engine_type: null,
                rastamozhka: null 
            } 

        }
    ]
    
}