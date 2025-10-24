import 'dart:io';
import 'package:amazcart/controller/admin/banner_controller.dart';
import 'package:amazcart/model/admin/BannerModel.dart';
import 'package:amazcart/utils/styles.dart';
import 'package:amazcart/widgets/custom_input_border.dart';
import 'package:fancy_shimmer_image/fancy_shimmer_image.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';
import 'package:image_picker/image_picker.dart';

class AddEditBanner extends StatefulWidget {
  final BannerModel? banner;

  AddEditBanner({this.banner});

  @override
  _AddEditBannerState createState() => _AddEditBannerState();
}

class _AddEditBannerState extends State<AddEditBanner> {
  final BannerController bannerController = Get.find<BannerController>();
  final _formKey = GlobalKey<FormState>();
  
  late TextEditingController titleController;
  late TextEditingController linkController;
  late TextEditingController sortOrderController;
  
  bool isActive = true;
  File? selectedImage;
  final ImagePicker _picker = ImagePicker();

  @override
  void initState() {
    super.initState();
    titleController = TextEditingController(text: widget.banner?.title ?? '');
    linkController = TextEditingController(text: widget.banner?.link ?? '');
    sortOrderController = TextEditingController(text: widget.banner?.sortOrder?.toString() ?? '1');
    isActive = widget.banner?.isActive ?? true;
  }

  @override
  void dispose() {
    titleController.dispose();
    linkController.dispose();
    sortOrderController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppStyles.appBackgroundColor,
      appBar: AppBar(
        backgroundColor: AppStyles.pinkColor,
        title: Text(
          widget.banner == null ? 'Add Banner' : 'Edit Banner',
          style: AppStyles.appFont.copyWith(
            color: Colors.white,
            fontSize: 18.sp,
            fontWeight: FontWeight.bold,
          ),
        ),
      ),
      body: Form(
        key: _formKey,
        child: SingleChildScrollView(
          padding: EdgeInsets.all(16.w),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // Image Section
              _buildImageSection(),
              
              SizedBox(height: 24.h),
              
              // Title Field
              _buildTextField(
                controller: titleController,
                label: 'Banner Title',
                hint: 'Enter banner title',
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Please enter banner title';
                  }
                  return null;
                },
              ),
              
              SizedBox(height: 16.h),
              
              // Link Field
              _buildTextField(
                controller: linkController,
                label: 'Banner Link (Optional)',
                hint: 'Enter banner link URL',
              ),
              
              SizedBox(height: 16.h),
              
              // Sort Order Field
              _buildTextField(
                controller: sortOrderController,
                label: 'Sort Order',
                hint: 'Enter sort order (1, 2, 3...)',
                keyboardType: TextInputType.number,
                validator: (value) {
                  if (value == null || value.isEmpty) {
                    return 'Please enter sort order';
                  }
                  if (int.tryParse(value) == null) {
                    return 'Please enter a valid number';
                  }
                  return null;
                },
              ),
              
              SizedBox(height: 16.h),
              
              // Active Status Switch
              _buildStatusSwitch(),
              
              SizedBox(height: 32.h),
              
              // Save Button
              _buildSaveButton(),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildImageSection() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          'Banner Image',
          style: AppStyles.appFont.copyWith(
            fontSize: 16.sp,
            fontWeight: FontWeight.w600,
            color: AppStyles.blackColor,
          ),
        ),
        SizedBox(height: 8.h),
        
        GestureDetector(
          onTap: _pickImage,
          child: Container(
            height: 150.h,
            width: Get.width,
            decoration: BoxDecoration(
              color: Colors.grey[100],
              borderRadius: BorderRadius.circular(12.r),
              border: Border.all(color: Colors.grey[300]!),
            ),
            child: selectedImage != null
                ? ClipRRect(
                    borderRadius: BorderRadius.circular(12.r),
                    child: Image.file(
                      selectedImage!,
                      fit: BoxFit.cover,
                    ),
                  )
                : widget.banner?.image != null
                    ? ClipRRect(
                        borderRadius: BorderRadius.circular(12.r),
                        child: FancyShimmerImage(
                          imageUrl: widget.banner!.image!,
                          boxFit: BoxFit.cover,
                          errorWidget: _buildImagePlaceholder(),
                        ),
                      )
                    : _buildImagePlaceholder(),
          ),
        ),
        
        SizedBox(height: 8.h),
        Text(
          'Tap to select image (Recommended: 16:6 aspect ratio)',
          style: AppStyles.appFont.copyWith(
            fontSize: 12.sp,
            color: Colors.grey[600],
          ),
        ),
      ],
    );
  }

  Widget _buildImagePlaceholder() {
    return Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Icon(
          Icons.add_photo_alternate,
          size: 48.w,
          color: Colors.grey[400],
        ),
        SizedBox(height: 8.h),
        Text(
          'Select Banner Image',
          style: AppStyles.appFont.copyWith(
            fontSize: 14.sp,
            color: Colors.grey[600],
          ),
        ),
      ],
    );
  }

  Widget _buildTextField({
    required TextEditingController controller,
    required String label,
    required String hint,
    TextInputType? keyboardType,
    String? Function(String?)? validator,
  }) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label,
          style: AppStyles.appFont.copyWith(
            fontSize: 14.sp,
            fontWeight: FontWeight.w600,
            color: AppStyles.blackColor,
          ),
        ),
        SizedBox(height: 8.h),
        TextFormField(
          controller: controller,
          keyboardType: keyboardType,
          validator: validator,
          style: AppStyles.appFont.copyWith(
            fontSize: 14.sp,
            color: AppStyles.blackColor,
          ),
          decoration: CustomInputBorder().inputDecoration(hint),
        ),
      ],
    );
  }

  Widget _buildStatusSwitch() {
    return Row(
      children: [
        Text(
          'Active Status',
          style: AppStyles.appFont.copyWith(
            fontSize: 14.sp,
            fontWeight: FontWeight.w600,
            color: AppStyles.blackColor,
          ),
        ),
        Spacer(),
        Switch(
          value: isActive,
          onChanged: (value) {
            setState(() {
              isActive = value;
            });
          },
          activeColor: AppStyles.pinkColor,
        ),
      ],
    );
  }

  Widget _buildSaveButton() {
    return Obx(() {
      return SizedBox(
        width: Get.width,
        height: 50.h,
        child: ElevatedButton(
          onPressed: bannerController.isSaving.value ? null : _saveBanner,
          style: ElevatedButton.styleFrom(
            backgroundColor: AppStyles.pinkColor,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12.r),
            ),
          ),
          child: bannerController.isSaving.value
              ? CircularProgressIndicator(color: Colors.white)
              : Text(
                  widget.banner == null ? 'Add Banner' : 'Update Banner',
                  style: AppStyles.appFont.copyWith(
                    fontSize: 16.sp,
                    fontWeight: FontWeight.bold,
                    color: Colors.white,
                  ),
                ),
        ),
      );
    });
  }

  Future<void> _pickImage() async {
    final XFile? image = await _picker.pickImage(source: ImageSource.gallery);
    if (image != null) {
      setState(() {
        selectedImage = File(image.path);
      });
    }
  }

  void _saveBanner() {
    if (_formKey.currentState!.validate()) {
      final bannerData = BannerModel(
        id: widget.banner?.id,
        title: titleController.text,
        link: linkController.text.isEmpty ? null : linkController.text,
        sortOrder: int.parse(sortOrderController.text),
        isActive: isActive,
        image: widget.banner?.image, // Keep existing image if no new image selected
      );

      if (widget.banner == null) {
        // Add new banner
        bannerController.addBanner(bannerData, selectedImage).then((success) {
          if (success) {
            Get.back(result: true);
          }
        });
      } else {
        // Update existing banner
        bannerController.updateBanner(bannerData, selectedImage).then((success) {
          if (success) {
            Get.back(result: true);
          }
        });
      }
    }
  }
}
