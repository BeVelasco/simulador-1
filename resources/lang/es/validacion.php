<?php
    return [
        /* Form Unidad de Medida */
        'umUnique'      => 'La unidad de medida "%um%" ya existe.',
        'umRequired'    => 'Debe ingresar el nombre de la unidad de medida.',
        'umMax'         => 'La unidad de medida no puede exceder los 30 caracteres.',
        'umRegex'       => 'La unidad de medida solo puede contener letras mayúsculas y minúsculas',
        'umDescripcion' => 'Descripción',
        'umAgregada'    => 'Unidad "%um%" agregada con éxito.',
        /* Form Producto */
        'desProdUnique'     => 'La descripción del producto es obligatoria.',
        'descProdMax'       => 'La descripción no puede tener más de 100 caracteres.',
        'descProdRegex'     => 'La descripción del producto solo pude contener letras mayúsculas y minúsculas.',
        'umProdRequired'    => 'La unidad de medida es requerida.',
        'umProdNumeric'     => 'La unidad de medida no existe, la página se actualizará.',
        'umProdExists'      => 'La unidad de medida no existe, la página se actualizará.',
        'porcProdRequired'  => 'La porción es requerida.',
        'porcProdNumeric'   => 'La porción debe ser un valor numérico.',
        'porcProdRegex'     => 'La porción no contiene un número válido.',
        'prodAgregado'      => 'Producto "%prod%" agregado con éxito.',
        'prodExisteUsuario' => '"%prod%" ya existe, elija otro nombre.',
        /* Iniciar Simulador */
        'iniSimIpRequired' => 'El id del producto es necesario para iniciar el simulador.',
        'iniSimIpExists'   => 'El id del producto no existe, la página se actualizará.',
        'iniSimProdMal'    => 'Este producto no le pertenece, la página se actualizará.',
        /* Precio Venta */
        'pvJExcelRequired' => 'Los datos de la tabla de ingredientes son necesarios.',
        'pvJPBBDRequired'  => 'El porcentaje de beneficio bruto deseado es obligatorio.',
        'pvJPBBDNumeric'   => 'El porcentaje de beneficio bruto deseado debe ser numérico.',
        'pvJPBBDBetween'   => 'El porcentaje de beneficio bruto deseado debe estar entre 1 y 99.',
        'jExcelConCeros'   => 'El producto # %num% tiene un costo de 0, edite o elimine.',
        /* Region Objetivo */
        'roEstadoRequired'   => 'El Estado Objetivo es requerido.',
        'roPersonasRequired' => 'El número de personas es requerido.',
        'roPersonasNumeric'  => 'El número de personas debe ser un valor numérico.',
        'roPersonasMin'      => 'El número de personas debe ser mínimo 1.',
        'roCiuObjRequired'   => 'La Ciudad Objetivo es requerida.',
        'roCiuObjNumeric'    => 'El Ciudad Objetivo es requerido',
        'roCiuObjBetween'    => 'El estado objetivo es requerido',
        'roPorcNumeric'      => 'El porcentaje debe ser un valor numérico',
        'roPorcNumeric'      => 'El porcentaje debe ser un valor numérico',
        'roPorcBetween'      => 'El porcentaje debe estar entre 1 y 100.',
        /* Segmentación */
        'segSegRequired' => 'Debe escoger un tipo de segmentación.'
    ];
?>