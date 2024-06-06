<?php

namespace Bss\ThemeDesign\Block\Adminhtml\System\Config\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field;

class Color extends Field
{
    /**
     * Render element html
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $html = $element->getElementHtml(); // default input field
        $color = $element->getEscapedValue();
        $clearClass = empty($color) ? ' sp-clear-display' : '';

        $html .= '<button type="button" id="' . $element->getHtmlId() . '_button" class="color-picker-button">
                    <div id="' . $element->getHtmlId() . '_color" class="color-display' . $clearClass . '" style="background-color:' . $color . ';"></div>
                  </button>';

        $html .= '<style>
            #' . $element->getHtmlId() . ' {
                width: calc(100% - 50px);
                display: inline-block;
                vertical-align: middle;
            }
            #' . $element->getHtmlId() . '_button {
                width: 33px;
                height: 33px;
                display: inline-block;
                vertical-align: middle;
                border: 1px solid #d1d1d1;
                border-left: none;
                cursor: pointer;
                background-color: #eaeaea;
                padding: 5px;
                box-sizing: border-box;
                position: relative;
            }
            .color-display {
                width: 100%;
                height: 100%;
            }
            .sp-clear-display {
                background-repeat: no-repeat;
                background-position: center;
                background-color: #fff;
                background-image: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNSIgaGVpZ2h0PSIyNSIgc3R5bGU9ImJhY2tncm91bmQ6I2ZmZiIgdmlld0JveD0iMCAwIDI1IDI1Ij4KICA8cGF0aCBmaWxsPSJub25lIiBzdHJva2U9IiNGMDAiIHN0cm9rZS1saW5lY2FwPSJzcXVhcmUiIGQ9Ik0wLjUsMC41IEwyNS41LDI0LjUiLz4KPC9zdmc+Cg==);
                border: solid 1px #adadad;
            }
        </style>';

        $html .= '<script type="text/javascript">
            require(["jquery", "jquery/colorpicker/js/colorpicker"], function($){
                $(document).ready(function() {
                    var input = $("#' . $element->getHtmlId() . '");
                    var button = $("#' . $element->getHtmlId() . '_button");
                    var colorDisplay = $("#' . $element->getHtmlId() . '_color");
                    
                    button.on("click", function() {
                        input.ColorPicker({
                            color: input.val(),
                            onChange: function (hsb, hex, rgb) {
                                input.val("#" + hex);
                                colorDisplay.css("background-color", "#" + hex);
                                colorDisplay.removeClass("sp-clear-display");
                            },
                            onSubmit: function(hsb, hex, rgb) {
                                input.val("#" + hex);
                                colorDisplay.css("background-color", "#" + hex);
                                colorDisplay.removeClass("sp-clear-display");
                                input.ColorPickerHide();
                            }
                        });
                        input.ColorPickerShow();
                    });
                    
                    input.on("change", function() {
                        if (!input.val()) {
                            colorDisplay.addClass("sp-clear-display");
                            colorDisplay.css("background-color", "transparent");
                        } else {
                            colorDisplay.removeClass("sp-clear-display");
                            colorDisplay.css("background-color", input.val());
                        }
                    });

                    if (!input.val()) {
                        colorDisplay.addClass("sp-clear-display");
                    }
                });
            });
        </script>';

        return $html;
    }
}
