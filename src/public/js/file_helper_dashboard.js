$(document).ready(function () {
});

var toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
var mainHeader = document.querySelector('.main-header');

function switchTheme(e) {
    if (e.target.checked) {
        if (!document.body.classList.contains('dark-mode')) {
            document.body.classList.add("dark-mode");
        }
        if (mainHeader.classList.contains('navbar-light')) {
            mainHeader.classList.add('navbar-dark');
            mainHeader.classList.remove('navbar-light');
        }
        industryChart.update({
            chart: {
                backgroundColor: '#343a40',
            },
            title: {
                style: {
                    color: '#FFFFFF',
                }
            },
            yAxis: {
                title: {
                    style: {
                        color: '#FFFFFF',
                    }
                },
                labels: {
                    style: {
                        color: '#FFFFFF',
                    }
                },
            },
            xAxis: {
                style: {
                    color: '#FFFFFF',
                },
                labels: {
                    style: {
                        color: '#FFFFFF',
                    }
                },
            },
            legend: {
                itemStyle: {
                    color: '#FFFFFF'
                },
            },
        })

        $('.even').css({
            'color': ' #dee2e6',
            'background-color': '#3a4047',
            'border-color': '#6c757d',
        });
    } else {
        if (document.body.classList.contains('dark-mode')) {
            document.body.classList.remove("dark-mode");
        }
        if (mainHeader.classList.contains('navbar-dark')) {
            mainHeader.classList.add('navbar-light');
            mainHeader.classList.remove('navbar-dark');
        }
        industryChart.update({
            chart: {
                backgroundColor: ''
            },
            title: {
                style: {
                    color: '#000000',
                }
            },
            yAxis: {
                title: {
                    style: {
                        color: '#000000',
                    }
                },
                labels: {
                    style: {
                        color: '#000000',
                    }
                },

            },
            xAxis: {
                style: {
                    color: '#000000',
                },
                labels: {
                    style: {
                        color: '#000000',
                    }
                },

            },
            legend: {
                itemStyle: {
                    color: '#000000'
                },
            },


        })
        $('.even').css({
            'color': ' #000000',
            'background-color': '#ffffff',
            'border-color': '#ffffff',
        });
    }
}

toggleSwitch.addEventListener('change', switchTheme, false);


