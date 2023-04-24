interface InlineJs {
	settings: Record< string, OptionProps >;
	sections: Record< string, string >;
	options: Record< string, number | string | boolean >;
	premiumSections: string[];
	premiumUrlPrefix: string;
}

interface InlineJsSettingsPage extends InlineJs {
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
}
