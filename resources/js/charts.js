if(typeof data !== 'undefined') {
    // xValues = data.yourTypes.map(({type_name}) => type_name);
    // yValues = data.yourTypes.map(({eventtypes}) => eventtypes.length);
    let xValues = data.yourTypes.map(({name}) => name);
    let yValues = data.yourTypes.map(({count}) => count);
    let barColors = [
        "#00AB89",
        "#F0E807",
        "#D43800",
        "#5900DE",
        "#164037",
        "#B3B17D",
        "#EDBBA8",
        "#B685FF",
        "#A6EDDF",
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
                backgroundColor: "rgba(0,0,255)",
                borderColor: "rgba(0,0,255,0.1)",
                data: yValues
            }]
        },
        options: {
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
            legend: {display: false},
            scales: {
                yAxes: [{
                    ticks: {min: 0, max: Math.max(...yValues)+1, stepSize: 1}
                }],
            }
        }
    });
}