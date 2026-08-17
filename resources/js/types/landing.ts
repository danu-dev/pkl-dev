export interface AlumniItem {
    id: number;
    name: string;
    username?: string;
    school_name: string;
    major_name?: string;
    division_name?: string;
    graduation_year?: string;
    current_position?: string;
    quote: string;
    photo_path?: string;
}

export interface GalleryItem {
    id: number;
    title: string;
    category: string;
    image_path: string;
    caption?: string;
}

export interface ProcedureItem {
    id: number;
    step_number: number;
    title: string;
    description: string;
    icon: string;
}
