AmCharts.AmXYChart = AmCharts.Class({
    inherits: AmCharts.AmRectangularChart,
    construct: function (a) {
        this.type = "xy";
        AmCharts.AmXYChart.base.construct.call(this, a);
        this.cname = "AmXYChart";
        this.theme = a;
        this.createEvents("zoomed");
        this.maxZoomFactor = 20;
        AmCharts.applyTheme(this, a, this.cname)
    },
    initChart: function () {
        AmCharts.AmXYChart.base.initChart.call(this);
        this.dataChanged && (this.updateData(), this.dataChanged = !1, this.dispatchDataUpdated = !0);
        this.updateScrollbar = !0;
        this.drawChart();
        this.autoMargins && !this.marginsUpdated &&
            (this.marginsUpdated = !0, this.measureMargins());
        var a = this.marginLeftReal,
            c = this.marginTopReal,
            b = this.plotAreaWidth,
            d = this.plotAreaHeight;
        this.graphsSet.clipRect(a, c, b, d);
        this.bulletSet.clipRect(a, c, b, d);
        this.trendLinesSet.clipRect(a, c, b, d)
    },
    prepareForExport: function () {
        var a = this.bulletSet;
        a.clipPath && this.container.remove(a.clipPath)
    },
    createValueAxes: function () {
        var a = [],
            c = [];
        this.xAxes = a;
        this.yAxes = c;
        var b = this.valueAxes,
            d, e;
        for (e = 0; e < b.length; e++) {
            d = b[e];
            var f = d.position;
            if ("top" == f || "bottom" == f) d.rotate = !0;
            d.setOrientation(d.rotate);
            f = d.orientation;
            "V" == f && c.push(d);
            "H" == f && a.push(d)
        }
        0 === c.length && (d = new AmCharts.ValueAxis(this.theme), d.rotate = !1, d.setOrientation(!1), b.push(d), c.push(d));
        0 === a.length && (d = new AmCharts.ValueAxis(this.theme), d.rotate = !0, d.setOrientation(!0), b.push(d), a.push(d));
        for (e = 0; e < b.length; e++) this.processValueAxis(b[e], e);
        a = this.graphs;
        for (e = 0; e < a.length; e++) this.processGraph(a[e], e)
    },
    drawChart: function () {
        AmCharts.AmXYChart.base.drawChart.call(this);
        AmCharts.ifArray(this.chartData) ?
            (this.chartScrollbar && this.updateScrollbars(), this.zoomChart()) : this.cleanChart();
        if (this.hideXScrollbar) {
            var a = this.scrollbarH;
            a && (this.removeListener(a, "zoomed", this.handleHSBZoom), a.destroy());
            this.scrollbarH = null
        }
        if (this.hideYScrollbar) {
            if (a = this.scrollbarV) this.removeListener(a, "zoomed", this.handleVSBZoom), a.destroy();
            this.scrollbarV = null
        }
        if (!this.autoMargins || this.marginsUpdated) this.dispDUpd(), this.chartCreated = !0, this.zoomScrollbars()
    },
    cleanChart: function () {
        AmCharts.callMethod("destroy", [this.valueAxes,
            this.graphs, this.scrollbarV, this.scrollbarH, this.chartCursor
        ])
    },
    zoomChart: function () {
        this.toggleZoomOutButton();
        this.zoomObjects(this.valueAxes);
        this.zoomObjects(this.graphs);
        this.zoomTrendLines();
        this.dispatchAxisZoom()
    },
    toggleZoomOutButton: function () {
        1 == this.heightMultiplier && 1 == this.widthMultiplier ? this.showZB(!1) : this.showZB(!0)
    },
    dispatchAxisZoom: function () {
        var a = this.valueAxes,
            c;
        for (c = 0; c < a.length; c++) {
            var b = a[c];
            if (!isNaN(b.min) && !isNaN(b.max)) {
                var d, e;
                "V" == b.orientation ? (d = b.coordinateToValue(-this.verticalPosition),
                    e = b.coordinateToValue(-this.verticalPosition + this.plotAreaHeight)) : (d = b.coordinateToValue(-this.horizontalPosition), e = b.coordinateToValue(-this.horizontalPosition + this.plotAreaWidth));
                if (!isNaN(d) && !isNaN(e)) {
                    if (d > e) {
                        var f = e;
                        e = d;
                        d = f
                    }
                    b.dispatchZoomEvent(d, e)
                }
            }
        }
    },
    zoomObjects: function (a) {
        var c = a.length,
            b;
        for (b = 0; b < c; b++) {
            var d = a[b];
            this.updateObjectSize(d);
            d.zoom(0, this.chartData.length - 1)
        }
    },
    updateData: function () {
        this.parseData();
        var a = this.chartData,
            c = a.length - 1,
            b = this.graphs,
            d = this.dataProvider,
            e =
                0,
            f, g;
        for (f = 0; f < b.length; f++)
            if (g = b[f], g.data = a, g.zoom(0, c), g = g.valueField) {
                var k;
                for (k = 0; k < d.length; k++) {
                    var m = d[k][g];
                    m > e && (e = m)
                }
            }
        for (f = 0; f < b.length; f++) g = b[f], g.maxValue = e;
        if (a = this.chartCursor) a.updateData(), a.type = "crosshair", a.valueBalloonsEnabled = !1
    },
    zoomOut: function () {
        this.verticalPosition = this.horizontalPosition = 0;
        this.heightMultiplier = this.widthMultiplier = 1;
        this.zoomChart();
        this.zoomScrollbars()
    },
    processValueAxis: function (a) {
        a.chart = this;
        a.minMaxField = "H" == a.orientation ? "x" : "y";
        a.minTemp =
            NaN;
        a.maxTemp = NaN;
        this.listenTo(a, "axisSelfZoomed", this.handleAxisSelfZoom)
    },
    processGraph: function (a) {
        AmCharts.isString(a.xAxis) && (a.xAxis = this.getValueAxisById(a.xAxis));
        AmCharts.isString(a.yAxis) && (a.yAxis = this.getValueAxisById(a.yAxis));
        a.xAxis || (a.xAxis = this.xAxes[0]);
        a.yAxis || (a.yAxis = this.yAxes[0]);
        a.valueAxis = a.yAxis
    },
    parseData: function () {
        AmCharts.AmXYChart.base.parseData.call(this);
        this.chartData = [];
        var a = this.dataProvider,
            c = this.valueAxes,
            b = this.graphs,
            d;
        for (d = 0; d < a.length; d++) {
            var e = {
                axes: {},
                x: {},
                y: {}
            }, f = a[d],
                g;
            for (g = 0; g < c.length; g++) {
                var k = c[g].id;
                e.axes[k] = {};
                e.axes[k].graphs = {};
                var m;
                for (m = 0; m < b.length; m++) {
                    var l = b[m],
                        q = l.id;
                    if (l.xAxis.id == k || l.yAxis.id == k) {
                        var n = {};
                        n.serialDataItem = e;
                        n.index = d;
                        var p = {}, h = Number(f[l.valueField]);
                        isNaN(h) || (p.value = h);
                        h = Number(f[l.xField]);
                        isNaN(h) || (p.x = h);
                        h = Number(f[l.yField]);
                        isNaN(h) || (p.y = h);
                        h = Number(f[l.errorField]);
                        isNaN(h) || (p.error = h);
                        n.values = p;
                        this.processFields(l, n, f);
                        n.serialDataItem = e;
                        n.graph = l;
                        e.axes[k].graphs[q] = n
                    }
                }
            }
            this.chartData[d] =
                e
        }
    },
    formatString: function (a, c, b) {
        var d = c.graph.numberFormatter;
        d || (d = this.numberFormatter);
        a = AmCharts.formatValue(a, c.values, ["value", "x", "y"], d); - 1 != a.indexOf("[[") && (a = AmCharts.formatDataContextValue(a, c.dataContext));
        return a = AmCharts.AmXYChart.base.formatString.call(this, a, c, b)
    },
    addChartScrollbar: function (a) {
        AmCharts.callMethod("destroy", [this.chartScrollbar, this.scrollbarH, this.scrollbarV]);
        if (a) {
            this.chartScrollbar = a;
            this.scrollbarHeight = a.scrollbarHeight;
            var c = "backgroundColor backgroundAlpha selectedBackgroundColor selectedBackgroundAlpha scrollDuration resizeEnabled hideResizeGrips scrollbarHeight updateOnReleaseOnly".split(" ");
            if (!this.hideYScrollbar) {
                var b = new AmCharts.SimpleChartScrollbar(this.theme);
                b.skipEvent = !0;
                b.chart = this;
                this.listenTo(b, "zoomed", this.handleVSBZoom);
                AmCharts.copyProperties(a, b, c);
                b.rotate = !0;
                this.scrollbarV = b
            }
            this.hideXScrollbar || (b = new AmCharts.SimpleChartScrollbar(this.theme), b.skipEvent = !0, b.chart = this, this.listenTo(b, "zoomed", this.handleHSBZoom), AmCharts.copyProperties(a, b, c), b.rotate = !1, this.scrollbarH = b)
        }
    },
    updateTrendLines: function () {
        var a = this.trendLines,
            c;
        for (c = 0; c < a.length; c++) {
            var b = a[c],
                b = AmCharts.processObject(b, AmCharts.TrendLine, this.theme);
            a[c] = b;
            b.chart = this;
            var d = b.valueAxis;
            AmCharts.isString(d) && (b.valueAxis = this.getValueAxisById(d));
            d = b.valueAxisX;
            AmCharts.isString(d) && (b.valueAxisX = this.getValueAxisById(d));
            b.valueAxis || (b.valueAxis = this.yAxes[0]);
            b.valueAxisX || (b.valueAxisX = this.xAxes[0])
        }
    },
    updateMargins: function () {
        AmCharts.AmXYChart.base.updateMargins.call(this);
        var a = this.scrollbarV;
        a && (this.getScrollbarPosition(a, !0, this.yAxes[0].position), this.adjustMargins(a, !0));
        if (a = this.scrollbarH) this.getScrollbarPosition(a, !1, this.xAxes[0].position), this.adjustMargins(a, !1)
    },
    updateScrollbars: function () {
        AmCharts.AmXYChart.base.updateScrollbars.call(this);
        var a = this.scrollbarV;
        a && (this.updateChartScrollbar(a, !0), a.draw());
        if (a = this.scrollbarH) this.updateChartScrollbar(a, !1), a.draw()
    },
    zoomScrollbars: function () {
        var a = this.scrollbarH;
        a && a.relativeZoom(this.widthMultiplier, -this.horizontalPosition / this.widthMultiplier);
        (a = this.scrollbarV) && a.relativeZoom(this.heightMultiplier, -this.verticalPosition / this.heightMultiplier)
    },
    fitMultiplier: function (a) {
        a > this.maxZoomFactor && (a = this.maxZoomFactor);
        return a
    },
    handleHSBZoom: function (a) {
        var c = this.fitMultiplier(a.multiplier);
        a = -a.position * c;
        var b = -(this.plotAreaWidth * c - this.plotAreaWidth);
        a < b && (a = b);
        this.widthMultiplier = c;
        this.horizontalPosition = a;
        this.zoomChart()
    },
    handleVSBZoom: function (a) {
        var c = this.fitMultiplier(a.multiplier);
        a = -a.position * c;
        var b = -(this.plotAreaHeight * c - this.plotAreaHeight);
        a < b && (a = b);
        this.heightMultiplier =
            c;
        this.verticalPosition = a;
        this.zoomChart()
    },
    handleAxisSelfZoom: function (a) {
        if ("H" == a.valueAxis.orientation) {
            var c = this.fitMultiplier(a.multiplier);
            a = -a.position * c;
            var b = -(this.plotAreaWidth * c - this.plotAreaWidth);
            a < b && (a = b);
            this.horizontalPosition = a;
            this.widthMultiplier = c
        } else c = this.fitMultiplier(a.multiplier), a = -a.position * c, b = -(this.plotAreaHeight * c - this.plotAreaHeight), a < b && (a = b), this.verticalPosition = a, this.heightMultiplier = c;
        this.zoomChart();
        c = this.graphs;
        for (a = 0; a < c.length; a++) c[a].setAnimationPlayed();
        this.zoomScrollbars()
    },
    handleCursorZoom: function (a) {
        var c = this.widthMultiplier * this.plotAreaWidth / a.selectionWidth,
            b = this.heightMultiplier * this.plotAreaHeight / a.selectionHeight,
            c = this.fitMultiplier(c),
            b = this.fitMultiplier(b);
        this.horizontalPosition = (this.horizontalPosition - a.selectionX) * c / this.widthMultiplier;
        this.verticalPosition = (this.verticalPosition - a.selectionY) * b / this.heightMultiplier;
        this.widthMultiplier = c;
        this.heightMultiplier = b;
        this.zoomChart();
        this.zoomScrollbars()
    },
    removeChartScrollbar: function () {
        AmCharts.callMethod("destroy", [this.scrollbarH, this.scrollbarV]);
        this.scrollbarV = this.scrollbarH = null
    },
    handleReleaseOutside: function (a) {
        AmCharts.AmXYChart.base.handleReleaseOutside.call(this, a);
        AmCharts.callMethod("handleReleaseOutside", [this.scrollbarH, this.scrollbarV])
    }
});