interface InlineJs {
	options: Record< string, number | string | boolean >;
	premiumSections: string[];
	premiumUrlPrefix: string;
	sections: Record< string, string >;
	settings: Record< string, OptionProps >;
}

interface InlineJsSettingsPage extends InlineJs {
	home_url: string;
	nonce: string;
	restUrl: string;
	definedKeys: string[];
}

interface InlineJsShortcodeDialog extends InlineJs {
	showHelpText: string;
	restUrl: string;
	definedKeys: string[];
}

interface OptionProps {
	label: string;
	tag: string;
	type: string;
	default: number | string | boolean;
	description?: string;
	descriptionlink?: string;
	descriptionlinktext?: string;
	placeholder?: string;
	options?: Record< string, string >;
	ui?: string;
	option: boolean;
}
