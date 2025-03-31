if(typeof data !== 'undefined') {
    // xValues = data.yourTypes.map(({type_name}) => type_name);
    // yValues = data.yourTypes.map(({eventtypes}) => eventtypes.length);
    let xValues = data.yourTypes.map(({name}) => name);
    let yValues = data.yourTypes.map(({count}) => count);
    let barColors = [
        "#EDBB71",
        "#68D7DB",
        "#DB5FA6",
        "#65B6FF",
        "#6EFF99",
        "#F97EE3",
        "#5EC78C",
        "#B685FF",
        "#FAEB62",
    ];

    new Chart("canvasYourTags", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {display: false},
            scales: {
                yAxes: [{
                    ticks: {min: 0, max: Math.max(...yValues)+1, stepSize: 1}
                }],
            }
        }
    });


    xValues = data.days;
    yValues = data.count;

    new Chart("canvasYour30", {
        type: "line",
        data: {
            labels: xValues,
            datasets: [{
                fill: false,
                backgroundColor: "rgb(79, 25, 83)",
                borderColor: "rgb(143, 81, 148, 0.3)",
                data: yValues
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: "Including your own events and events you joined"
            },
            legend: {display: false},
            scales: {
                yAxes: [{
                    ticks: {min: 0, max: Math.max(...data.count)+1, stepSize: 1}
                }],
            }
        }
    });


    xValues = data.joinedTypes.map(({name}) => name);
    yValues = data.joinedTypes.map(({count}) => count);

    new Chart("canvasJoinedTags", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {display: false},
            scales: {
                yAxes: [{
                    ticks: {min: 0, max: Math.max(...yValues)+1, stepSize: 1}
                }],
            }
        }
    });
}