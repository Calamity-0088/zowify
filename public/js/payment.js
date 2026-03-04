const mp = new MercadoPago('TEST-7eaf921a-7cb3-47a2-8466-fd7925fda390', {
    locale: 'es-PE'
});
const bricksBuilder = mp.bricks();
let response;

const renderCardPaymentBrick = async (bricksBuilder) => {
    const settings = {
        initialization: {
            amount: 100, // monto a ser pago
            payer: {
                email: "",
            },
        },
        customization: {
            visual: {
                style: {
                    theme: 'dark', // | 'dark' | 'bootstrap' | 'flat'
                    customVariables: {
                        inputBackgroundColor: "#13151c",
                        formBackgroundColor: "#0a0c12",
                        baseColor: "#10d9a6",
                        outlinePrimaryColor: "none"
                    },
                },
            },
            paymentMethods: {
                maxInstallments: 1,
            },
        },
        callbacks: {
            onReady: () => {
                // callback llamado cuando Brick esté listo
            },
            onSubmit: (cardFormData) => {
                //  callback llamado cuando el usuario haga clic en el botón enviar los datos
                //  ejemplo de envío de los datos recolectados por el Brick a su servidor
                return new Promise(async (resolve, reject) => {
                    try {
                        response = await axios.post("/workspace_php/zowify/public/Api/Payment/store", cardFormData);
                        resolve();
                        console.log(response);
                        window.cardPaymentBrickController.unmount();
                        renderStatusScreenBrick(bricksBuilder);
                    } catch (error) {
                        reject();
                    }
                });
            },
            onError: (err) => {
                // callback llamado para todos los casos de error de Brick
                console.error(err.response
                    ? `${err.response.statusText}\n${err.response.data.error}`
                    : err
                );
            },
        },
    };
    window.cardPaymentBrickController = await bricksBuilder.create('cardPayment', 'cardPaymentBrick_container', settings);
};

const renderStatusScreenBrick = async (bricksBuilder) => {
    const settings = {
        initialization: {
            paymentId: response.data.id, // id de pago para mostrar
        },
        customization: {
            visual: {
                showExternalReference: true,
                style: {
                    theme: 'dark', // 'default' | 'dark' | 'bootstrap' | 'flat'
                    customVariables: {
                        inputBackgroundColor: "#13151c",
                        formBackgroundColor: "#0a0c12",
                        baseColor: "#10d9a6",
                        successColor: "#10d9a6",
                        borderRadiusLarge: "none"
                    }
                }
            }
        },
        callbacks: {
            onReady: () => {
                /*
                  Callback llamado cuando Brick está listo.
                  Aquí puede ocultar cargamentos de su sitio, por ejemplo.
                */
            },
            onError: (err) => {
                // callback llamado solicitada para todos los casos de error de Brick
                console.error(err.response
                    ? `${err.response.statusText}\n${err.response.data.error}`
                    : err
                );
            },
        },
    };
    window.statusScreenBrickController = await bricksBuilder.create(
        'statusScreen',
        'statusScreenBrick_container',
        settings,
    );
};