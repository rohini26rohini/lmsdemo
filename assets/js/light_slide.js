        $(document).ready(function () {
            $('#challenge_owl').lightSlider({
                //                auto: true,
                item: 3,
                vertical: true,
                freeMove: false,
                loop: false,
                enableDrag: true,
                easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
                speed: 600,

                responsive: [
                    {
                        breakpoint: 1199,
                        settings: {
                            item: 3,
                            slideMove: 1,
                            slideMargin: 6,
                        }
            },
                    {
                        breakpoint: 800,
                        settings: {
                            item: 2,
                            slideMove: 1,
                        }
            }
        ]
            });
        });
