//canvas changing

function createCanvas()
{
    var stageSize = getCanvasSize();

    $("#canvas-content").width(stageSize[2]);
    $("#canvas-content").height(stageSize[3]);
     canvasStage = new Kinetic.Stage({
        container: canvasContainer,
        width: stageSize[2],
        height: stageSize[3],
        stageSize:stageSize[5]
      //  id: 'canvas-main-image'
    });

    removeObjectByDefault(leftTopCurveArea);
    removeObjectByDefault(rightTopCurveArea);
    removeObjectByDefault(leftBottomCurveArea);
    removeObjectByDefault(rightBottomCurveArea);

    removeObjectByDefault(leftTopCurveNotVisible);
    removeObjectByDefault(rightTopCurveNotVisible);
    removeObjectByDefault(leftBottomCurveNotVisible);
    removeObjectByDefault(rightBottomCurveNotVisible);

    removeObjectByDefault(leftFrame);
    removeObjectByDefault(rightFrame);
    removeObjectByDefault(topFrame);
    removeObjectByDefault(bottomFrame);

    canvasLayer = new Kinetic.Layer();

    if(stageSize[4] == 'oval')
    {
        canvasBackgroundBox = new Kinetic.Ellipse({
            x: stageSize[2]/2,
            y: stageSize[3]/2,
            radius:{
            x: stageSize[0]/2,
            y: stageSize[1]/2},
            fill: currentColor,
            stroke: backBorder,
            strokeWidth: 1,
            id: backgroundRect
        });

        leftTopCurveNotVisible = drawNotVisibleCurveArea('lefttop');
        rightTopCurveNotVisible = drawNotVisibleCurveArea('righttop');
        leftBottomCurveNotVisible = drawNotVisibleCurveArea('leftbottom');
        rightBottomCurveNotVisible = drawNotVisibleCurveArea('rightbottom');

        canvasLayer.add(leftTopCurveNotVisible);
        canvasLayer.add(rightTopCurveNotVisible);
        canvasLayer.add(leftBottomCurveNotVisible);
        canvasLayer.add(rightBottomCurveNotVisible);
        if(stageSize[0] < stageSize[2] || stageSize[1] < stageSize[3])
        {
            leftTopCurveArea = drawCurveArea('lefttop');
            rightTopCurveArea = drawCurveArea('righttop');
            leftBottomCurveArea = drawCurveArea('leftbottom');
            rightBottomCurveArea = drawCurveArea('rightbottom');

            canvasLayer.add(leftTopCurveArea);
            canvasLayer.add(rightTopCurveArea);
            canvasLayer.add(leftBottomCurveArea);
            canvasLayer.add(rightBottomCurveArea);

            moveTo('top',leftTopCurveArea);
            moveTo('top',rightTopCurveArea);
            moveTo('top',leftBottomCurveArea);
            moveTo('top',rightBottomCurveArea);
        }


            moveTo('top',leftTopCurveNotVisible);
            moveTo('top',rightTopCurveNotVisible);
            moveTo('top',leftBottomCurveNotVisible);
            moveTo('top',rightBottomCurveNotVisible);


    }
    else
    {
        canvasBackgroundBox = new Kinetic.Rect({
            x: (stageSize[2] - stageSize[0])/2,
            y: (stageSize[3] - stageSize[1])/2,
            width: stageSize[0],
            height: stageSize[1],
            fill: currentColor,
            stroke: backBorder,
            strokeWidth: 1,
            id: backgroundRect
        });

        if(stageSize[0] < stageSize[2] || stageSize[1] < stageSize[3])
        {
            leftFrame = drawFrameArea('left');
            rightFrame = drawFrameArea('right');
            topFrame = drawFrameArea('top');
            bottomFrame = drawFrameArea('bottom');

            canvasLayer.add(leftFrame);
            canvasLayer.add(rightFrame);
            canvasLayer.add(topFrame);
            canvasLayer.add(bottomFrame);

            moveTo('top',leftFrame);
            moveTo('top',rightFrame);
            moveTo('top',topFrame);
            moveTo('top',bottomFrame);
        }
    }

    // add the shape to the layer
    canvasLayer.add(canvasBackgroundBox);



    // add the layer to the stage
    canvasStage.add(canvasLayer);

    setActiveObject(canvasBackgroundBox);
    canvasBackgroundBox.on('mousedown', function() {
        setActiveObject(this);
    });

   // canvasLayer.remove(canvasBackgroundBox);
  //   console.log(canvasBackgroundBox);
}


function getCanvasSize()
{
    //size
    var sizeId = $("#canvas-size option:selected").val();
    var sizeString = $("#canvas-size-" + sizeId).val();
    var canvasSizes = sizeString.split(';');
    canvasSizes[0] = cmToPx(canvasSizes[0]);
    canvasSizes[1] = cmToPx(canvasSizes[1]);
    canvasSizes[2] = cmToPx(canvasSizes[2]);
    canvasSizes[3] = cmToPx(canvasSizes[3]);
    canvasSizes = convertToDefaultSize(canvasSizes);
    return canvasSizes;
}

function convertToDefaultSize(size)
{
    var widthCof = canvasWidthDefault/size[2];
    size[2] = canvasWidthDefault;
    size[3] = parseInt(size[3] * widthCof);
    size[0] = parseInt(size[0] * widthCof);
    size[1] = parseInt(size[1] * widthCof);

    return size;
}

function setCanvasSize()
{
    var stageSize = getCanvasSize();
    $("#canvas-content").width(stageSize[2]);
    $("#canvas-content").height(stageSize[3]);
    var prevFill = canvasBackgroundBox.getFill();
    var prevZIndex = canvasBackgroundBox.getZIndex();
    canvasBackgroundBox.remove();
    canvasStage.attrs.stageSize = stageSize[5];


    removeObjectByDefault(leftTopCurveArea);
    removeObjectByDefault(rightTopCurveArea);
    removeObjectByDefault(leftBottomCurveArea);
    removeObjectByDefault(rightBottomCurveArea);

    removeObjectByDefault(leftTopCurveNotVisible);
    removeObjectByDefault(rightTopCurveNotVisible);
    removeObjectByDefault(leftBottomCurveNotVisible);
    removeObjectByDefault(rightBottomCurveNotVisible);

    removeObjectByDefault(leftFrame);
    removeObjectByDefault(rightFrame);
    removeObjectByDefault(topFrame);
    removeObjectByDefault(bottomFrame);



    if(stageSize[4] == 'oval')
    {
        canvasBackgroundBox = new Kinetic.Ellipse({
            x: stageSize[2]/2,
            y: stageSize[3]/2,
            radius:{
                x: stageSize[0]/2,
                y: stageSize[1]/2},
            fill: prevFill,
            stroke: backBorder,
            strokeWidth: 1,
            id: backgroundRect
        });


        leftTopCurveNotVisible = drawNotVisibleCurveArea('lefttop');
        rightTopCurveNotVisible = drawNotVisibleCurveArea('righttop');
        leftBottomCurveNotVisible = drawNotVisibleCurveArea('leftbottom');
        rightBottomCurveNotVisible = drawNotVisibleCurveArea('rightbottom');

        canvasLayer.add(leftTopCurveNotVisible);
        canvasLayer.add(rightTopCurveNotVisible);
        canvasLayer.add(leftBottomCurveNotVisible);
        canvasLayer.add(rightBottomCurveNotVisible);


        if(stageSize[0] < stageSize[2] || stageSize[1] < stageSize[3])
        {
            leftTopCurveArea = drawCurveArea('lefttop');
            rightTopCurveArea = drawCurveArea('righttop');
            leftBottomCurveArea = drawCurveArea('leftbottom');
            rightBottomCurveArea = drawCurveArea('rightbottom');

            canvasLayer.add(leftTopCurveArea);
            canvasLayer.add(rightTopCurveArea);
            canvasLayer.add(leftBottomCurveArea);
            canvasLayer.add(rightBottomCurveArea);

             moveTo('top',leftTopCurveArea);
             moveTo('top',rightTopCurveArea);
             moveTo('top',leftBottomCurveArea);
             moveTo('top',rightBottomCurveArea);
         }


            moveTo('top',leftTopCurveNotVisible);
            moveTo('top',rightTopCurveNotVisible);
            moveTo('top',leftBottomCurveNotVisible);
            moveTo('top',rightBottomCurveNotVisible);


    }
    else
    {
        canvasBackgroundBox = new Kinetic.Rect({
            x: (stageSize[2] - stageSize[0])/2,
            y: (stageSize[3] - stageSize[1])/2,
            width: stageSize[0],
            height: stageSize[1],
            fill: prevFill,
            stroke: backBorder,
            strokeWidth: 1,
            id: backgroundRect
        });

        if(stageSize[0] < stageSize[2] || stageSize[1] < stageSize[3])
        {
            leftFrame = drawFrameArea('left');
            rightFrame = drawFrameArea('right');
            topFrame = drawFrameArea('top');
            bottomFrame = drawFrameArea('bottom');

            canvasLayer.add(leftFrame);
            canvasLayer.add(rightFrame);
            canvasLayer.add(topFrame);
            canvasLayer.add(bottomFrame);

            moveTo('top',leftFrame);
            moveTo('top',rightFrame);
            moveTo('top',topFrame);
            moveTo('top',bottomFrame);
        }

    }
    setActiveObject(canvasBackgroundBox);
    canvasBackgroundBox.on('mousedown', function() {
        setActiveObject(this);
    });
    canvasLayer.add(canvasBackgroundBox);
    canvasBackgroundBox.setZIndex(prevZIndex);
    canvasLayer.draw();
    canvasStage.setWidth(stageSize[2]);
    canvasStage.setHeight(stageSize[3]);

}



function canvasBackground(color)
{
    canvasBackgroundBox.setFill(color);
    canvasLayer.draw();
}

function canvasToWindow()
{
    activeElement.setStroke(false);
    activeElement.setStrokeWidth(false);
    canvasLayer.draw();
    canvasStage.toDataURL({
        callback: function(dataUrl) {
            /*
             * here you can do anything you like with the data url.
             * In this tutorial we'll just open the url with the browser
             * so that you can see the result as an image
             */
            window.open(dataUrl);
        }
        //,
        //mimeType: 'image/jpeg',
        //quality: 0.5
    });
}

function getActiveObject()
{
    return activeElement;
}
function setActiveObject(object)
{
    if(activeElement)
    {
        if(activeElement == canvasBackgroundBox)
        {
            activeElement.setStroke(backBorder);
        }
        else
        {
            activeElement.setStroke(false);
            activeElement.setStrokeWidth(false);
        }
    }

    activeElement = object;
    if(activeElement.attrs.class != frameClass && activeElement.attrs.class != curveClass)
    {
        activeElement.setStroke(activeColor);
        activeElement.setStrokeWidth(1);
    }
    canvasLayer.draw();
}
function setOverOut(object)
{
    object.on('mouseover', function() {
        if(activeElement != this)
        {
            this.setStroke(hoverColor);
            this.setStrokeWidth(1);
            canvasLayer.draw();
        }
    });
    object.on('mouseout', function() {
        if(activeElement != this)
        {
            this.setStroke(false);
            this.setStrokeWidth(0);
            canvasLayer.draw();
        }
    });


}
/* colorpicker*/

function getPickerMousePos(canvas, evt) {
    var rect = canvas.getBoundingClientRect();

    return {
        x: parseInt(evt.clientX - rect.left),
        y: parseInt(evt.clientY - rect.top)
    };
}
function getPickerColor(context,imageObj,mousePos)
{
    var imageData = context.getImageData(0, 0, imageObj.width, imageObj.width );
    var data = imageData.data;

    var x = mousePos.x - pickerPadding;
    var y = mousePos.y - pickerPadding;

    var red = data[((imageObj.width * y) + x) * 4];
    var green = data[((imageObj.width * y) + x) * 4 + 1];
    var blue = data[((imageObj.width * y) + x) * 4 + 2];
    var colorPicked = 'rgb(' + red + ',' + green + ',' + blue + ')';
    return colorPicked;
}
function showColor(color)
{
    //$("#current-color-box").css('background-color',color);
//    var colors = new Array();
//    colors[0] = 'rgb(227,6,19)';
//    colors[1] = 'rgb(255,237,0)';
//    colors[2] = 'rgb(0,150,64)';
//    colors[3] = 'rgb(49,39,131)';
//    colors[4] = 'rgb(29,29,27)';
//    colors[5] = 'rgb(255,255,255)';
//    var arrowWidth = 11;
//    var colorsNum = 6;
//    var palleteWidth = 261;
//    var arrowCell = palleteWidth/colorsNum;
//    for(var i = 0;i < colorsNum;i++)
//    {
//        if(color == colors[i])
//        {
//            var arrowPosition = parseInt((arrowCell * i) + (arrowCell/2) - (arrowWidth/2));
//            $("#canvas-picker-arrow").css('margin-left',arrowPosition + "px");
//            break;
//        }
//    }
}

function setPickerArrow(color)
{
    var colors = new Array();
    colors[0] = 'rgb(227,6,19)';
    colors[1] = 'rgb(255,237,0)';
    colors[2] = 'rgb(0,150,64)';
    colors[3] = 'rgb(49,39,131)';
    colors[4] = 'rgb(29,29,27)';
    colors[5] = 'rgb(255,255,255)';
    var arrowWidth = 11;
    var colorsNum = 6;
    var palleteWidth = 261;
    var arrowCell = palleteWidth/colorsNum;
    for(var i = 0;i < colorsNum;i++)
    {
        if(color == colors[i])
        {
            var arrowPosition = parseInt((arrowCell * i) + (arrowCell/2) - (arrowWidth/2));
            $("#canvas-picker-arrow").animate({'margin-left':arrowPosition + "px"}, 150);
            break;
        }
    }
}
function setChosenColor(color) {
    currentColor = color;
    setPickerArrow(color);
}
function initPicker(imageObj) {
    var canvasPicker = document.getElementById('canvas-picker');
    var contextPicker = canvasPicker.getContext('2d');
    var mouseDown = false;

  //  context.strokeStyle = '#444';
 //   context.lineWidth = 2;

    canvasPicker.addEventListener('mousedown', function() {
        mouseDown = true;
    }, false);

    canvasPicker.addEventListener('click', function(evt) {
        var color = undefined;
        var mousePos = getPickerMousePos(canvasPicker, evt);
        if(mousePos !== null && mousePos.x > pickerPadding && mousePos.x < pickerPadding + imageObj.width && mousePos.y > pickerPadding && mousePos.y < pickerPadding + imageObj.height) {
            color = getPickerColor(contextPicker,imageObj,mousePos);
            setChosenColor(color);
            setObjectColor();
        }
        mouseDown = false;
    }, false);

    canvasPicker.addEventListener('mouseout', function() {
            showColor(currentColor);
        },false);

        canvasPicker.addEventListener('mousemove', function(evt) {
        var mousePos = getPickerMousePos(canvasPicker, evt);

        var color = undefined;

        if(mousePos !== null && mousePos.x > pickerPadding && mousePos.x < pickerPadding + imageObj.width && mousePos.y > pickerPadding && mousePos.y < pickerPadding + imageObj.height) {
            color = getPickerColor(contextPicker,imageObj,mousePos);
            showColor(color);
        }
    }, false);


    contextPicker.drawImage(imageObj, 0, 0);

}


/*end colorpicker */


/* text drawing */
function addUpdateCanvasText()
{
    if(activeElement.shapeType == 'Text')
    {
        setTextOptionsToObject(activeElement);
    }
    else
    {
        addCanvasText();
    }
}
function addCanvasText()
{
    var colorText = "black";//currentColor;
    var textContent = $("#canvas-text").val();
    var textWidth = getTextWidth(textContent);

    var textOptions = getTextOptions();
 //   if(textOptions.font_Weight == 'normal')
  //      textOptions.font_Weight = '';
 //   if(textOptions.font_Style == 'normal')
 //       textOptions.font_Style = '';

    var complexText = new Kinetic.Text({
        //x: 150,
       // y: 0,
        text: textContent,
        fontSize: parseInt(textOptions.font_Size),
        fontFamily: textOptions.font_Family,
        fill: colorText,
        width: textWidth,
        padding: 0,
       // fontStyle: textOptions.font_Weight + " " + textOptions.font_Style,
       // align: textOptions.font_Align,
        draggable: true,
        dragOnTop: false,
    //    id: textBlockClass + '-' + textCounter,
        class: textBlockClass
    });

    complexText.setOffset(parseInt(complexText.getWidth()/2),parseInt(complexText.getHeight()/2));
    setCenterObject('both',complexText);
    //setActiveObject(complexText);
    setOverOut(complexText);
    complexText.on('mousedown', function() {
        setTextOptionsFromObject(this);
        setActiveObject(this);
    });
    textCounter ++;

    canvasLayer.add(complexText);

    var stageSize = getCanvasSize();
    if(canvasBackgroundBox.shapeType == 'Ellipse')
    {
        if(stageSize[0] < stageSize[2] || stageSize[1] < stageSize[3])
        {
            moveTo('top',leftTopCurveArea);
            moveTo('top',rightTopCurveArea);
            moveTo('top',leftBottomCurveArea);
            moveTo('top',rightBottomCurveArea);
        }
        moveTo('top',leftTopCurveNotVisible);
        moveTo('top',rightTopCurveNotVisible);
        moveTo('top',leftBottomCurveNotVisible);
        moveTo('top',rightBottomCurveNotVisible);
    }

    if(canvasBackgroundBox.shapeType == 'Rect' && (stageSize[0] < stageSize[2] || stageSize[1] < stageSize[3]))
    {
        moveTo('top',leftFrame);
        moveTo('top',rightFrame);
        moveTo('top',topFrame);
        moveTo('top',bottomFrame);
    }


    canvasLayer.draw();
}

/* end text drawing*/

/* draw pics */
function addCanvasPic(picObject)
{
    var stageSize = getCanvasSize();
    var prevWidth = picObject.width;
    var prevHeight = picObject.height;
    $(picObject).css('width','auto');
    $(picObject).css('height','auto');
    if(parseInt(picObject.width) > stageSize[0])
    {
        $(picObject).css('width',stageSize[0] + 'px');
        var cof = parseInt(picObject.width)/stageSize[0];
        $(picObject).css('height',parseInt(picObject.height/cof) + 'px');
    }


    var imageObject = new Kinetic.Image({
        image: picObject,
        draggable:true,
        dragOnTop: false,
        id: picImageClass + "-" + picCounter,
        class: picImageClass
    });
    $(picObject).css('width',prevWidth);
    $(picObject).css('height',prevHeight);
    imageObject.setOffset(parseInt(imageObject.getWidth()/2),parseInt(imageObject.getHeight()/2));
    setCenterObject('both',imageObject);
   // setActiveObject(imageObject);
    setOverOut(imageObject);
    imageObject.on('mousedown', function() {
        setActiveObject(this);
    });
    picCounter ++;

    canvasLayer.add(imageObject);

    if(canvasBackgroundBox.shapeType == 'Ellipse')
    {
        if(stageSize[0] < stageSize[2] || stageSize[1] < stageSize[3])
        {
            moveTo('top',leftTopCurveArea);
            moveTo('top',rightTopCurveArea);
            moveTo('top',leftBottomCurveArea);
            moveTo('top',rightBottomCurveArea);
        }
        moveTo('top',leftTopCurveNotVisible);
        moveTo('top',rightTopCurveNotVisible);
        moveTo('top',leftBottomCurveNotVisible);
        moveTo('top',rightBottomCurveNotVisible);
    }

    if(canvasBackgroundBox.shapeType == 'Rect' && (stageSize[0] < stageSize[2] || stageSize[1] < stageSize[3]))
    {
        moveTo('top',leftFrame);
        moveTo('top',rightFrame);
        moveTo('top',topFrame);
        moveTo('top',bottomFrame);
    }
    canvasLayer.draw();
  //  console.log(imageObject);
}

/* end pics */

/* draw images */
function addCanvasImage(imageObj)
{
    var stageSize = getCanvasSize();

    var prevWidth = imageObj.width;
    var prevHeight = imageObj.height;
    $(imageObj).css('width','auto');
    $(imageObj).css('height','auto');
    if(parseInt(imageObj.width) > stageSize[0])
    {
        $(imageObj).css('width',stageSize[0] + 'px');
        var cof = parseInt(imageObj.width)/stageSize[0];
        $(imageObj).css('height',parseInt(imageObj.height/cof) + 'px');
    }


    var imageObject = new Kinetic.Image({
        //  x: 50,
        //  y: 50,
        image: imageObj,
        draggable:true,
        dragOnTop: false,
        id: picImageClass + "-" + picCounter,
        class: imageClass,
        orig:imageObj.src,
        filter:'normal'
    });
    $(imageObj).css('width',prevWidth);
    $(imageObj).css('height',prevHeight);
    imageObject.setOffset(parseInt(imageObject.getWidth()/2),parseInt(imageObject.getHeight()/2));
    setCenterObject('both',imageObject);
    // setActiveObject(imageObject);
    setOverOut(imageObject);
    imageObject.on('mousedown', function() {
        setActiveObject(this);
        setUploadOptions(this);
    });
    picCounter ++;

    canvasLayer.add(imageObject);

    if(canvasBackgroundBox.shapeType == 'Ellipse')
    {
        if(stageSize[0] < stageSize[2] || stageSize[1] < stageSize[3])
        {
            moveTo('top',leftTopCurveArea);
            moveTo('top',rightTopCurveArea);
            moveTo('top',leftBottomCurveArea);
            moveTo('top',rightBottomCurveArea);
        }
        moveTo('top',leftTopCurveNotVisible);
        moveTo('top',rightTopCurveNotVisible);
        moveTo('top',leftBottomCurveNotVisible);
        moveTo('top',rightBottomCurveNotVisible);
    }

    if(canvasBackgroundBox.shapeType == 'Rect' && (stageSize[0] < stageSize[2] || stageSize[1] < stageSize[3]))
    {
        moveTo('top',leftFrame);
        moveTo('top',rightFrame);
        moveTo('top',topFrame);
        moveTo('top',bottomFrame);
    }
    canvasLayer.draw();
}
function setObjectFilter()
{
    if(activeElement.attrs.class == imageClass)
    {
        var filter = $("#canvas-object-filter option:selected").val();
        activeElement.attrs.filter = filter;
        var imageObj = new Image();
        imageObj.src = activeElement.attrs.orig;
        activeElement.setImage(imageObj);

        var applyFilter = '';
        if(filter == 'grayscale')
            applyFilter = Kinetic.Filters.Grayscale;
        if(filter == 'invert')
            applyFilter = Kinetic.Filters.Invert;
        if(filter == 'brighten')
            applyFilter = Kinetic.Filters.Brighten;
        if(applyFilter)
        {
            activeElement.applyFilter(applyFilter, null, function() {
                canvasLayer.draw();
            });
        }
        canvasLayer.draw();
    }
   // console.log(activeElement);
}
/* end image */

/* set color for different objects */
function setObjectColor()
{
    var objectType = activeElement.shapeType;
    var activeElementClass = activeElement.attrs.class;
    if(objectType == 'Rect' || objectType == 'Ellipse')
    {
        if(activeElement == canvasBackgroundBox)
        {
            canvasBackground(currentColor);
        }
        else
        {
            if(activeElement.attrs.class == frameClass)
            {
                rightFrame.setFill(currentColor);
                leftFrame.setFill(currentColor);
                topFrame.setFill(currentColor);
                bottomFrame.setFill(currentColor);
            }
        }
    }
    if(activeElement.attrs.class == curveClass)
    {
        leftTopCurveArea.setFill(currentColor);
        leftBottomCurveArea.setFill(currentColor);
        rightTopCurveArea.setFill(currentColor);
        rightBottomCurveArea.setFill(currentColor);
    }
    //alert(activeElement.attrs.class);
    if(objectType == 'Image' && activeElementClass == picImageClass)
    {
        setPicColor();
    }
    if(objectType == 'Text' && activeElementClass == textBlockClass)
    {
        setTextColor();
    }
    canvasLayer.draw();
}
function setTextColor()
{
    activeElement.setFill(currentColor);
    canvasLayer.draw();
}

function getRgbFromString(color)
{
    var colorParts = color.split(",");
    return {
        r: parseInt(colorParts[0].substr(4)),
        g: parseInt(colorParts[1]),
        b: parseInt(colorParts[2].substr(0,colorParts[2].length - 1))
    };
}

function setPicColor()
{
    var canvas = new Kinetic.Canvas(activeElement.attrs.width, activeElement.attrs.height);
    var context = canvas.getContext();
    context.drawImage(activeElement.getImage(), 0, 0);
    try {
        var imageData = context.getImageData(0, 0, canvas.getWidth(), canvas.getHeight());

        var data = imageData.data;
        var rgbColorKey = getRgbFromString(currentColor);

        for (var i = 0; i < data.length; i += 4) {
            if(data[i+3] != 0)
            {
                data[i] = rgbColorKey.r;
                data[i + 1] = rgbColorKey.g;
                data[i + 2] = rgbColorKey.b;
            }
        }
        context.putImageData(imageData, 0, 0);
        var that = activeElement;
        Kinetic.Type._getImage(imageData, function(imageObj) {
            that.setImage(imageObj);
        });
    }
    catch(e) {
        Kinetic.Global.warn('Unable to apply filter. ' + e.message);
    }
    setTimeout(function(){canvasLayer.draw();},200);
    //canvasLayer.draw();
}

/* end setting */

/* transform options */
function rotateObject(way)
{
    if(activeElement != canvasBackgroundBox && activeElement.attrs.class != frameClass && activeElement.attrs.class != curveNotVisibleClass && activeElement.attrs.class != curveClass)
    {
        var rotateTo =  Math.PI/rotateAngle;
        if(way == 'left')
            rotateTo = -1 * Math.PI/rotateAngle;
        activeElement.rotate(rotateTo);
        activeElement.setOffset(parseInt(activeElement.getWidth()/2),parseInt(activeElement.getHeight()/2));
        canvasLayer.draw();
        //console.log(activeElement.getScale());
    }
    return false;
}
function scaleObject(sign)
{
    if(activeElement != canvasBackgroundBox && activeElement.attrs.class != frameClass && activeElement.attrs.class != curveNotVisibleClass && activeElement.attrs.class != curveClass)
    {
        var scaleTo = scalePoint;
        if(sign == 'minus')
            scaleTo = -1 * scalePoint;
        scaleTo  += activeElement.getScale().x;
        activeElement.setScale(scaleTo);
        activeElement.setOffset(parseInt(activeElement.getWidth()/2),parseInt(activeElement.getHeight()/2));
        canvasLayer.draw();
    }
    return false;
}
function setCenterObject(position,object)
{
    if(object == 'current')
        object = activeElement;
    if(object != canvasBackgroundBox && object.attrs.class != frameClass && object.attrs.class != curveNotVisibleClass && object.attrs.class != curveClass)
    {
        var xPosition = 0;
        var yPosition = 0;
        var canvasSize = getCanvasSize();
        if(position == 'vertical')
        {
            yPosition = parseInt(canvasSize[3]/2);
            xPosition = object.getX();
        }
        if(position == 'horizontal')
        {
            xPosition = parseInt(canvasSize[2]/2);
            yPosition = object.getY();
        }
        if(position == 'both')
        {
            xPosition = parseInt(canvasSize[2]/2);
            yPosition = parseInt(canvasSize[3]/2);
        }
      //  alert(xPosition + " " + yPosition);
        object.setPosition(xPosition,yPosition);
      //  console.log(object);
        canvasLayer.draw();
    }
    return false;
}
function removeObject(object)
{
    if(object)
    {
        if(object == 'current')
            object = activeElement;
        if(object != canvasBackgroundBox && object.attrs.class != frameClass && object.attrs.class != curveNotVisibleClass && object.attrs.class != curveClass)
        {
                object.remove();
                setActiveObject(canvasBackgroundBox);
                canvasLayer.draw();
        }
    }
}
function removeObjectByDefault(object)
{
    if(object)
    {
        if(object == 'current')
            object = activeElement;
        object.remove();
        setActiveObject(canvasBackgroundBox);
        canvasLayer.draw();
    }
}

function getTextOptions()
{
    return {
        font_Size:       $("#canvas-font-size option:selected").val(),
        font_Family:     $("#canvas-font-family option:selected").val()
     //   font_Weight:     $("#canvas-font-weight option:selected").val(),
    //    font_Style:      $("#canvas-font-style option:selected").val(),
    //    font_Align:      $("#canvas-font-align option:selected").val()
    }

}
function changeTextOption(object,option)
{
    var objectId = object.id;
    var value = $("#" + objectId + " option:selected").val();
    setTextOption(value,option);
}
function setTextOption(value,option)
{
    if(option != 'all')
    {
        $("#canvas-text").css(option,value);
    }
    else
    {
        var textOptions = getTextOptions();
        $("#canvas-text").css('font-size',textOptions.font_Size);
        $("#canvas-text").css('font-family',textOptions.font_Family);
    //    $("#canvas-text").css('font-weight',textOptions.font_Weight);
   //     $("#canvas-text").css('font-style',textOptions.font_Style);
        $("#canvas-text").css('text-align',textOptions.font_Align);
    }
}
function setTextOptionsFromObject(object)
{
    var fontStyles = object.getFontStyle().split(' ');

    $("#canvas-text").val(object.getText());
    if($("#canvas-font-size").data('selectik') != undefined)
    {
        $('#canvas-font-size').data('selectik').changeCS({value: object.getFontSize() + "px"});
    }
    else
    {
        $(window).load(function()
        {
            $('#canvas-font-size').data('selectik').changeCS({value: object.getFontSize() + "px"});
        });
    }
    var family = object.getFontFamily();

    var familyParts = family.split(",");
    if(familyParts[0][0] != "'")
    {
        familyParts[0] = "'" + familyParts[0] + "'";
        family = familyParts[0] + familyParts[1];
    }
    if($("#canvas-font-family").data('selectik') != undefined)
    {
        $('#canvas-font-family').data('selectik').changeCS({value: family});
    }
    else
    {
        $(window).load(function()
        {
            $('#canvas-font-family').data('selectik').changeCS({value: family});
        });
    }

  //  $("#canvas-font-size").val(object.getFontSize() + "px");
  //  $("#canvas-font-family").val(object.getFontFamily());
  //  $("#canvas-font-weight").val(fontStyles[0]);
  //  $("#canvas-font-style").val(fontStyles[1]);
 //   $("#canvas-font-align").val(object.getAlign());


    setTextOption(0,'all');
}
function setTextOptionsToObject(object)
{
    var textOptions = getTextOptions();
    var canvasText = $("#canvas-text").val();

//    if(textOptions.font_Weight == 'normal')
 //       textOptions.font_Weight = '';
  //  if(textOptions.font_Style == 'normal')
     //   textOptions.font_Style = '';

    object.setFontSize(parseInt(textOptions.font_Size));
   // object.setFontStyle(textOptions.font_Weight + " " + textOptions.font_Style);
    object.setFontFamily(textOptions.font_Family);
    object.setAlign(textOptions.font_Align);
    object.setWidth(getTextWidth(canvasText));
    object.setOffset(parseInt(object.getWidth()/2),parseInt(object.getHeight()/2));
    object.setText(canvasText);

    canvasLayer.draw();
}

function setUploadOptions(object)
{
    var objectFilter = object.attrs.filter;
    $("#canvas-object-filter").val(objectFilter);
}

function getTextWidth(text)
{
    var maxTextWidth = 0;
    text = text.replace(/\r\n|\r|\n/g,"<br/>");
    var textLines = text.split("<br/>");

    var textOptions = getTextOptions();

    for(var i = 0; i < textLines.length; i++){
        var textWidth = getTextLineWidth(textLines[i],textOptions);
        if(parseInt(textWidth) > parseInt(maxTextWidth))
            maxTextWidth = textWidth;
    }
    return maxTextWidth + 5;
}
function getTextLineWidth(textLine,textOptions)
{
    var stageSize = getCanvasSize();
    var canvas = new Kinetic.Canvas(stageSize[0],stageSize[1]);
    var context = canvas.getContext();
 //   if(textOptions.font_Weight == 'normal')
 //       textOptions.font_Weight = '';
 //   if(textOptions.font_Style == 'normal')
 //       textOptions.font_Style = '';

    context.font = textOptions.font_Size + " " + textOptions.font_Family;
   // context.fontStyle = textOptions.font_Weight + " " + textOptions.font_Style;

    // get text metrics
    var metrics = context.measureText(textLine);
    var width = metrics.width;
    return width;
}

/* end transform */

/* system options */
function loadFromJson(stageJson,lastPicId,picsJson,mediaUrl)
{
    if(stageJson)
    {
        stageJson = JSON.stringify(stageJson);
        var picsObject  = picsJson;

        picCounter = lastPicId;
        $("#" + canvasContainer).html('');
        canvasLayer.removeChildren();
        canvasStage.removeChildren();
        canvasStage.reset();
        canvasStage = Kinetic.Node.create(stageJson, canvasContainer);
        //$("#canvas-size").val(canvasStage.attrs.stageSize);

        canvasLayer = canvasStage.children[0];

        var children = new Array();
        var removeChildren = new Array();
        var images = new Array();
        var imageCounter = 0;
        var childrenCounter = 0;
        for(var objectKey in canvasLayer.children)
        {
            if(isInt(objectKey))
            {
                if((canvasLayer.children[objectKey].shapeType == 'Rect' && canvasLayer.children[objectKey].attrs.id == backgroundRect) || (canvasLayer.children[objectKey].shapeType == 'Ellipse' && canvasLayer.children[objectKey].attrs.id == backgroundRect))
                {
                    canvasBackgroundBox = canvasLayer.children[objectKey];
                    setActiveObject(canvasBackgroundBox);
                }
                else
                {
                    if(canvasLayer.children[objectKey].attrs.class == frameClass)
                    {
                        if(canvasLayer.children[objectKey].attrs.loc == 'left')
                            leftFrame = canvasLayer.children[objectKey];
                        if(canvasLayer.children[objectKey].attrs.loc == 'top')
                            topFrame = canvasLayer.children[objectKey];
                        if(canvasLayer.children[objectKey].attrs.loc == 'right')
                            rightFrame = canvasLayer.children[objectKey];
                        if(canvasLayer.children[objectKey].attrs.loc == 'bottom')
                            bottomFrame = canvasLayer.children[objectKey];
                    }

                        if(canvasLayer.children[objectKey].attrs.class == curveNotVisibleClass)
                        {
                            if(canvasLayer.children[objectKey].attrs.loc == 'lefttop')
                            {
                                leftTopCurveNotVisible = drawNotVisibleCurveArea('lefttop');
                                children[childrenCounter] = leftTopCurveNotVisible;
                                //canvasLayer.add(leftTopCurveNotVisible);
                            }
                            if(canvasLayer.children[objectKey].attrs.loc == 'righttop')
                            {
                                rightTopCurveNotVisible = drawNotVisibleCurveArea('righttop');
                                children[childrenCounter] = rightTopCurveNotVisible;
                                //canvasLayer.add(rightTopCurveNotVisible);
                            }
                            if(canvasLayer.children[objectKey].attrs.loc == 'rightbottom')
                            {
                                rightBottomCurveNotVisible = drawNotVisibleCurveArea('rightbottom');
                                children[childrenCounter] = rightBottomCurveNotVisible;
                                //canvasLayer.add(rightBottomCurveNotVisible);
                            }
                            if(canvasLayer.children[objectKey].attrs.loc == 'leftbottom')
                            {
                                leftBottomCurveNotVisible = drawNotVisibleCurveArea('leftbottom');
                                children[childrenCounter] = leftBottomCurveNotVisible;
                                //canvasLayer.add(leftBottomCurveNotVisible);
                            }
                            removeChildren[childrenCounter] = canvasLayer.children[objectKey];
                            childrenCounter++;
                        }
                        if(canvasLayer.children[objectKey].attrs.class == curveClass)
                        {
                            if(canvasLayer.children[objectKey].attrs.loc == 'lefttop')
                            {
                                leftTopCurveArea = drawCurveArea('lefttop');
                                leftTopCurveArea.setFill(canvasLayer.children[objectKey].getFill());
                                children[childrenCounter] = leftTopCurveArea;
                                //canvasLayer.add(leftTopCurveArea);
                                //leftTopCurveArea.moveToTop();
                            }
                            if(canvasLayer.children[objectKey].attrs.loc == 'righttop')
                            {
                                rightTopCurveArea = drawCurveArea('righttop');
                                rightTopCurveArea.setFill(canvasLayer.children[objectKey].getFill());
                                children[childrenCounter] = rightTopCurveArea;
                                //canvasLayer.add(rightTopCurveArea);
                                //rightTopCurveArea.moveToTop();
                            }
                            if(canvasLayer.children[objectKey].attrs.loc == 'leftbottom')
                            {
                                leftBottomCurveArea = drawCurveArea('leftbottom');
                                leftBottomCurveArea.setFill(canvasLayer.children[objectKey].getFill());
                                children[childrenCounter] = leftBottomCurveArea;
                                //canvasLayer.add(leftBottomCurveArea);
                                //leftBottomCurveArea.moveToTop();
                            }
                            if(canvasLayer.children[objectKey].attrs.loc == 'rightbottom')
                            {
                                rightBottomCurveArea = drawCurveArea('rightbottom');
                                rightBottomCurveArea.setFill(canvasLayer.children[objectKey].getFill());
                                children[childrenCounter] = rightBottomCurveArea;
                                //canvasLayer.add(rightBottomCurveArea);
                                //rightBottomCurveArea.moveToTop();
                            }
                            removeChildren[childrenCounter] = canvasLayer.children[objectKey];
                            childrenCounter++;
                        }



                        if(canvasLayer.children[objectKey].attrs.class != frameClass && canvasLayer.children[objectKey].attrs.class != curveNotVisibleClass && canvasLayer.children[objectKey].attrs.class != curveClass)
                        {
                            setOverOut(canvasLayer.children[objectKey]);
                        }

                }

                    canvasLayer.children[objectKey].on('mousedown', function() {
                        setActiveObject(this);
                        if(this.attrs.class == imageClass)
                        {
                            setUploadOptions(this);
                        }
                        if(this.shapeType == 'Text')
                        {
                            setTextOptionsFromObject(this);
                        }
                    });


                    if(canvasLayer.children[objectKey].shapeType == 'Image')
                    {
                        for(var imageKey in picsObject)
                        {
                            if(canvasLayer.children[objectKey].attrs.id == picsObject[imageKey].id)
                            {
                                var imageObj = new Image();
                                imageObj.src = mediaUrl + 'imageparts/' + picsObject[imageKey].image;
                                if(imageObj.complete)
                                {
                                    images[imageCounter] = imageObj;
                                    imageCounter++;
                                }
                                canvasLayer.children[objectKey].setImage(imageObj);
                                break;
                            }
                        }
                    }

            }
        }
   /*     for(var i = 0; i < imageCounter;i++)
        {
            for(var objectKey in canvasLayer.children)
            {
                if(canvasLayer.children[objectKey].shapeType == 'Image')
                {
                    canvasLayer.children[objectKey].setImage(images[i]);
                    break;
                }
            }
        }*/
        setActiveObject(canvasBackgroundBox);


        $("#" + canvasContainer).width(canvasStage.getWidth());
        $("#" + canvasContainer).height(canvasStage.getHeight());
        if(canvasBackgroundBox.shapeType == 'Ellipse')
        {
            for(var i = 0; i < childrenCounter;i++)
            {
                removeChildren[i].remove();
                canvasLayer.add(children[i]);
            }

            /*moveTo(leftBottomCurveArea);
            moveTo(rightBottomCurveArea);
            moveTo(leftTopCurveArea);
            moveTo(rightTopCurveArea);
            moveTo(leftBottomCurveNotVisible);
            moveTo(rightBottomCurveNotVisible);
            moveTo(leftTopCurveNotVisible);
            moveTo(rightTopCurveNotVisible);*/
        }
        canvasStage.draw();
        canvasLayer.draw();
        $(window).load( function(){
            if(canvasBackgroundBox.shapeType == 'Rect')
                currentColor = leftFrame.getFill();
            if(canvasBackgroundBox.shapeType == 'Ellipse' && leftTopCurveArea)
                currentColor = leftTopCurveArea.getFill();
            canvasStage.draw();
            $('#canvas-size').data('selectik').changeCS({value: canvasStage.attrs.stageSize});
            canvasLayer.draw();
        } );
        if($('#canvas-size').data('selectik') != undefined)
        {
            if(canvasBackgroundBox.shapeType == 'Rect')
                currentColor = leftFrame.getFill();
            if(canvasBackgroundBox.shapeType == 'Ellipse' && leftTopCurveArea)
                currentColor = leftTopCurveArea.getFill();
            canvasStage.draw();
            $('#canvas-size').data('selectik').changeCS({value: canvasStage.attrs.stageSize});
            canvasLayer.draw();
        }

    }
}
function saveToJson(baseUrl,itemId,itemUrl)
{
    showPreloader();
    activeElement.setStroke(false);
    activeElement.setStrokeWidth(false);
    canvasLayer.draw();
    var stageSize = canvasStage.attrs.stageSize;
    var stageJson = canvasStage.toJSON();

    //console.log(activeElement);

    var pics = new Array();
    var picsCounter = 0;

    for(var objectKey in canvasLayer.children)
    {

            if(canvasLayer.children[objectKey].shapeType == 'Image')
            {
                pics[picsCounter] = {};
                pics[picsCounter]['id'] = canvasLayer.children[objectKey].attrs.id;
                pics[picsCounter]['image'] = canvasLayer.children[objectKey].attrs.image.src;
                picsCounter++;
            }
    }
    canvasStage.toDataURL({
        callback: function(dataUrl) {
            $.post(baseUrl + 'imagecreate/show/savedesign',{'itemId':itemId,'stageJson':stageJson,'lastPicId':picCounter,'images':pics,'canvas':dataUrl,'size':stageSize},function(data)
            {
                hidePreloader();
                window.location.href = itemUrl;
            });
        }
    });


}
function showuploadImages()
{
    $("#canvas-upload-images").load('viewuploadimages.php');
}
function cmToPx(cm)
{
    return parseInt((cm * cmToPxCof)/2);
}
function pxToCm(px)
{
    return parseInt((px * pxToCmCof)*2);
}
function moveTo(way,object)
{
    if(object == 'current')
    {
        object = activeElement;
    }
    if(way == 'top')
    {
        object.moveToTop();
    }
    if(way == 'bottom')
    {
        object.moveToBottom();
    }

    var stageSize = getCanvasSize();
    if(canvasBackgroundBox.shapeType == 'Ellipse')
    {
        if(stageSize[0] < stageSize[2] || stageSize[1] < stageSize[3])
        {
            leftTopCurveArea.moveToTop();
            leftBottomCurveArea.moveToTop();
            rightTopCurveArea.moveToTop();
            rightBottomCurveArea.moveToTop();
        }
        leftTopCurveNotVisible.moveToTop();
        leftBottomCurveNotVisible.moveToTop();
        rightTopCurveNotVisible.moveToTop();
        rightBottomCurveNotVisible.moveToTop();

    }
    if(canvasBackgroundBox.shapeType == 'Rect')
    {
        if(stageSize[0] < stageSize[2] || stageSize[1] < stageSize[3])
        {
            leftFrame.moveToTop();
            rightFrame.moveToTop();
            topFrame.moveToTop();
            bottomFrame.moveToTop();
        }
    }

    canvasBackgroundBox.moveToBottom();
    canvasLayer.draw();
}
function isInt(value) {
    return !isNaN(parseInt(value,10)) && (parseFloat(value,10) == parseInt(value,10));
}
function drawCurveArea(loc)
{
    var canvasSize = getCanvasSize();
    var w = canvasSize[0];var h = canvasSize[1];
    var x = ((canvasSize[2] - canvasSize[0])/2);
    var y = ((canvasSize[3] - canvasSize[1])/2);


    var kappa = .5522848;
    ox = (w / 2) * kappa, // control point offset horizontal
        oy = (h / 2) * kappa, // control point offset vertical
        xe = x + w,           // x-end
        ye = y + h,           // y-end
        xm = x + w / 2,       // x-middle
        ym = y + h / 2;


    var line1ToX = 0, line1ToY = 0,line2ToX = 0,line2ToY = 0,line3ToX = 0,line3ToY = 0;
    var moveToX = 0,moveToY = 0;
    var x1 = 0,x2 = 0,x3 = 0,x4 = 0,x5 = 0,x6 = 0;


    if(loc == 'lefttop')
    {
        moveToX = x;
        moveToY = ym;
        x1 = x;x2 = ym - oy;x3 = xm - ox;x4 =  y;x5 =  xm + 2;x6 =  y;
        line3ToY = canvasSize[3]/2;
        line1ToX = (canvasSize[2]/2) + 2;
    }
    if(loc == 'righttop')
    {
        moveToX = xm ;
        moveToY = y;
        x1 = xm + ox;x2 =  y;x3 = xe;x4 =  ym - oy;x5 = xe;x6 = ym + 2;
        line1ToX = canvasSize[2];
        line1ToY = (canvasSize[3]/2) + 2;
        line2ToX = canvasSize[2];
        line3ToX = canvasSize[2]/2;
    }
    if(loc == 'leftbottom')
    {
        moveToX = xm;
        moveToY = ye;
        x1 = xm - ox;x2 =  ye;x3 =  x;x4 = ym + oy;x5 =  x;x6 = ym - 1;
        line1ToY = (canvasSize[3]/2) - 1;
        line2ToY = canvasSize[3];
        line3ToX = (canvasSize[2]/2);
        line3ToY = canvasSize[3];
    }
    if(loc == 'rightbottom')
    {
        moveToX = xe;
        moveToY = ym;
        x1 = xe;x2 =  ym + oy;x3 = xm + ox;x4 =  ye; x5 =  xm - 1;x6 = ye;
        line1ToX = (canvasSize[2]/2) - 1 ;
        line1ToY = canvasSize[3];
        line2ToX = canvasSize[2];
        line2ToY = canvasSize[3];
        line3ToX = canvasSize[2];
        line3ToY = (canvasSize[3]/2);
    }

    var object = new Kinetic.Shape({
        drawFunc: function(canvas) {
            var ctx = canvas.getContext();
            ctx.beginPath();
            ctx.moveTo(moveToX, moveToY);
            ctx.bezierCurveTo(x1, x2, x3, x4, x5, x6);
            ctx.lineTo(line1ToX,line1ToY);
            ctx.lineTo(line2ToX,line2ToY);
            ctx.lineTo(line3ToX,line3ToY);
            ctx.closePath();
            canvas.fillStroke(this);
        },
        fill: currentColor,
         // stroke: false,
        // strokeWidth: false,
        class: curveClass,
        loc:loc
    });

    object.on('mousedown', function() {
        setActiveObject(this);
    });



    return object;
}


function drawNotVisibleCurveArea(location)
{
    var canvasSize = getCanvasSize();
    var w = canvasSize[2];var h = canvasSize[3];
    var x = 0;
    var y = 0;


    var kappa = .5522848;
    ox = (w / 2) * kappa, // control point offset horizontal
        oy = (h / 2) * kappa, // control point offset vertical
        xe = x + w,           // x-end
        ye = y + h,           // y-end
        xm = x + w / 2,       // x-middle
        ym = y + h / 2;


    var lineToX = -1, lineToY = -1;
    var moveToX = 0,moveToY = 0;
    var x1 = 0,x2 = 0,x3 = 0,x4 = 0,x5 = 0,x6 = 0;


    if(location == 'lefttop')
    {
        moveToX = x - 1;
        moveToY = ym;
        x1 = x;x2 = ym - oy;x3 = xm - ox;x4 =  y;x5 =  xm;x6 =  y - 1;
    }
    if(location == 'righttop')
    {
        moveToX = xm;
        moveToY = y - 1;
        x1 = xm + ox;x2 =  y;x3 = xe;x4 =  ym - oy;x5 = xe + 1;x6 = ym;
        lineToX = canvasSize[2] + 1;
    }
    if(location == 'leftbottom')
    {
        moveToX = xm;
        moveToY = ye + 1;
        x1 = xm - ox;x2 =  ye;x3 =  x;x4 = ym + oy;x5 =  x - 1;x6 = ym;
        lineToY = canvasSize[3] + 1;
    }
    if(location == 'rightbottom')
    {
        moveToX = xe + 1;
        moveToY = ym;
        x1 = xe;x2 =  ym + oy;x3 = xm + ox;x4 =  ye; x5 =  xm;x6 = ye + 1;
        lineToY = canvasSize[3] + 1;
        lineToX = canvasSize[2] + 1;
    }

    var object = new Kinetic.Shape({
        drawFunc: function(canvas) {
            var ctx = canvas.getContext();
            ctx.beginPath();
            ctx.moveTo(moveToX, moveToY);
            ctx.bezierCurveTo(x1, x2, x3, x4, x5, x6);
            ctx.lineTo(lineToX,lineToY);
            ctx.closePath();
            canvas.fillStroke(this);
        },
        fill: notVisibleFillColor,
        stroke: strokeCurve,
        strokeWidth: 1,
        class: curveNotVisibleClass,
        loc:location
    });

    return object;
}


function drawFrameArea(location)
{
    var x = 0,y = 0;
    var width = 0,height = 0;
    var canvasSize = getCanvasSize();
    if(location == 'left')
    {
        width = ((canvasSize[2] - canvasSize[0])/2) - 1;
        height = canvasSize[3] - ((canvasSize[3] - canvasSize[1])/2) + 2;
    }
    if(location == 'right')
    {
        x = canvasSize[2] - ((canvasSize[2] - canvasSize[0])/2) + 1;
        y = ((canvasSize[3] - canvasSize[1])/2) - 2;
        width = ((canvasSize[2] - canvasSize[0])/2) + 1;
        height = canvasSize[3] - ((canvasSize[3] - canvasSize[1])/2) + 2;
    }
    if(location == 'top')
    {
        x = ((canvasSize[2] - canvasSize[0])/2) - 2;
        width = canvasSize[2] - ((canvasSize[2] - canvasSize[0])/2) + 2;
        height = ((canvasSize[3] - canvasSize[1])/2) - 1;
    }
    if(location == 'bottom')
    {
        width = canvasSize[2] - ((canvasSize[2] - canvasSize[0])/2) + 2;
        height = ((canvasSize[3] - canvasSize[1])/2) +  2;
        y =  canvasSize[3] - ((canvasSize[3] - canvasSize[1])/2) + 1;
    }
    var object = new Kinetic.Rect({
        x: x,
        y: y,
        width: width,
        height: height,
        fill: currentColor,
        //stroke: backBorder,
       // strokeWidth: 1,
        loc: location,
        class:frameClass
    });
    object.on('mousedown', function() {
        setActiveObject(this);
    });
    return object;
}

/* end */